<?php

namespace App\View\Components\Site;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Doctor;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\MenuItemRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageTitleBreadcrumbs extends Component
{
    public string $title;
    public string $page_title;
    public ?string $subTitle = null;
    public bool $stop = false;
    public ?string $description = null;
    public ?string $seo_keywords = null;
    public ?object $image = null;
    public ?string $ogImage = null;
    public array $breadcrumbs = [];
    protected NavigationRepositoryInterface $navigationRepository;
    private Request $request;

    public function __construct(
        Request                            $request,
        NavigationRepositoryInterface      $navigationRepository,
        public MenuItemRepositoryInterface $menuItemRepository,
        public CategoryRepositoryInterface $categoryRepository,
    )
    {
        $this->navigationRepository = $navigationRepository;
        $this->request = $request;
    }

    public function preRender(): void
    {
        $this->breadcrumbs();
        View::share('breadcrumbs', $this->breadcrumbs);
        View::share('page_title', $this->page_title);
        View::share('subTitle', $this->subTitle);
        View::share('image', $this->image);
        View::share('ogImage', $this->ogImage);
    }

    public function render(): \Illuminate\Contracts\View\View|string|Closure
    {
        $this->preRender();
        return view('components.site.page-title-breadcrumbs');
    }

    public function breadcrumbs(): void
    {
        $route_name = Route::currentRouteName();
        $structure = $this->navigationRepository->getNavigationMenuItemsAll('main_navigation');
        $footer = $this->navigationRepository->getNavigationMenuItemsAll('footer_navigation');
        $top_menu = $this->navigationRepository->getNavigationMenuItemsAll('service_navigation');
        $structure = $structure->concat($footer)->concat($top_menu);
        $this->build($structure, 0, $route_name);
    }

    public function buildByMenu($structure, $level, $current_route)
    {
        foreach ($structure as $item) {
            if (!$this->stop) {
                $this->breadcrumbs[$level] = [
                    'title'  => $item->title,
                    'active' => false,
                    'link'   => ($item->slug != '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $item->slug) : 'javascript:void();')
                ];
                $this->title = $item->title . ($item->seo_keywords ? ' ::: ' . $item->seo_keywords : '');
                $this->page_title = $item->title;
                if ($item->sub_title) {
                    $this->title = $item->sub_title . ($item->seo_keywords ? ' ::: ' . $item->seo_keywords : '');
                    $this->page_title = $item->sub_title;
                }

                if (LaravelLocalization::getLocalizedURL(App::getLocale(), $item->slug) == strtok($this->request->getUri(), '?') || (($item->slug ?? '/') == strtok($this->request->getUri(), '?')) || (url(($item->slug ?? '/')) . '/' == strtok($this->request->getUri(), '?'))) {
                    $this->breadcrumbs[$level]['active'] = 'true';
                    $this->breadcrumbs = array_slice($this->breadcrumbs, 0, $level + 1);
                    $this->stop = true;
                    $this->subTitle = $item->sub_title;
                    $this->seo_keywords = $item->seo_keywords;
                    if ($item->getFirstMediaUrl('preview')) {
                        $this->image = $item->getFirstMedia('preview');
                    }

                    if ($current_route === 'index') {
                        $this->description = __('site.home_meta_description');
                    }
                    break;
                }
                if (count($item->children)) {
                    $this->buildByMenu($item->children, $level + 1, $current_route);
                }
            }
        }
    }

    public function build($structure, $level, $current_route): void
    {
        foreach ($structure as $item) {
            if (!$this->stop) {
                $this->breadcrumbs[$level] = ['title' => $item->title, 'active' => false, 'link' => ($item->slug != '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $item->slug) : 'javascript:void();')];
                $this->title = $item->title . ($item->seo_keywords ? ' ::: ' . $item->seo_keywords : '');
                $this->page_title = $item->title;
                if ($item->sub_title) {
                    $this->title = $item->sub_title . ($item->seo_keywords ? ' ::: ' . $item->seo_keywords : '');
                    $this->page_title = $item->sub_title;
                }

                if (LaravelLocalization::getLocalizedURL(App::getLocale(), $item->slug) == strtok($this->request->getUri(), '?')) {
                    $this->breadcrumbs[$level]['active'] = 'true';
                    $this->breadcrumbs = array_slice($this->breadcrumbs, 0, $level + 1);
                    $this->stop = true;
                    $this->subTitle = $item->sub_title;
                    $this->seo_keywords = $item->seo_keywords;
                    if ($item->getFirstMediaUrl('preview')) {
                        $this->image = $item->getFirstMedia('preview');
                    }
                    if ($current_route === 'static-page') {
                        $staticPage = $this->request->staticPage;
                        if ($staticPage->seo_keywords) {
                            $this->seo_keywords = $staticPage->seo_keywords;
                        }
                        $this->description = $staticPage->description ? Str::limit(strip_tags($staticPage->description)) : '';
                    }
                    if ($current_route === 'contacts') {
                        $this->description = __('site.contacts_meta_description');
                    }
                    if ($current_route === 'sitemap') {
                        $this->description = __('site.sitemap_meta_description');
                    }
                    if ($current_route === 'index') {
                        $this->description = __('site.home_meta_description');
                    }
                    break;
                }

                if ($current_route === 'category') {
                    $category = $this->request->category;
                    $this->description = $category->meta_description ?: ($category->description ? Str::limit(strip_tags($category->description)) : '');
                    $this->page_title = $category->title;
                    $this->title = $category->title . ($category->seo_keywords ? ' ::: ' . $category->seo_keywords : '');
                    $hierarchy = collect();
                    if ($category->parent) {
                        $hierarchy->add($category->parent);
                        if ($category->parent->parent) {
                            $hierarchy->add($category->parent->parent);
                        }
                    }
                    if ($hierarchy->count()) {
                        $hierarchy = $hierarchy->reverse();
                        foreach ($hierarchy as $key => $hierarchyITem) {
                            $this->breadcrumbs[$level] = ['title' => $hierarchyITem->title, 'active' => false, 'link' => route('category', ['category' => $hierarchyITem->slug])];
                            $level = $key + 1 + $level;
                        }
                    }
                    $this->breadcrumbs[$level] = ['title' => $category->title, 'active' => true, 'link' => route('category', ['category' => $category->slug])];
                    $this->stop = true;
                }
                if ($current_route === 'article') {
                    $article = $this->request->article;
                    $this->page_title = $article->title;
                    $category = $article->categories->first();
                    $this->title = $article->title . ($article->seo_keywords ? ' ::: ' . $article->seo_keywords : '');
                    $this->description = $article->description ? Str::limit(strip_tags($article->description)) : '';
                    $menuItem = $this->menuItemRepository->getModel()->where('slug', 'like',  '%' . $category->slug)->first();
                    if ($menuItem && $menuItem->parent_id) {
                        $this->breadcrumbs[$level] = ['title' => $menuItem->parent->title, 'active' => false, 'link' => $menuItem->parent->slug !== '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $menuItem->parent->slug) : 'javascript:void(0);'];
                        ++$level;
                    }
                    if ($article->getFirstMediaUrl('preview')) {
                        $this->ogImage = $article->getFirstMediaUrl('preview');
                    }
                    $this->breadcrumbs[$level] = ['title' => $category->title, 'active' => true, 'link' => route('category', ['category' => $category->slug])];
                    $this->breadcrumbs[$level + 1] = ['title' => $article->title, 'active' => true, 'link' => \route('article', [$category, $article])];
                    $this->stop = true;
                }
                if ($current_route === 'vacancy') {
                    $vacancy = $this->request->vacancy;
                    $this->page_title = $vacancy->title;
                    $category = $this->categoryRepository->getModel()->where('active', true)->where('taxonomy', 'vacancies')->first();
                    $this->title = $vacancy->title . ($vacancy->seo_keywords ? ' ::: ' . $vacancy->seo_keywords : '');
                    $this->description = $vacancy->description ? Str::limit(strip_tags($vacancy->description)) : '';
                    $this->breadcrumbs[$level] = ['title' => $category->title, 'active' => true, 'link' => route('category', ['category' => $category->slug])];
                    $this->breadcrumbs[$level + 1] = ['title' => $vacancy->title, 'active' => true, 'link' => \route('vacancy', [$category, $vacancy])];
                    $this->stop = true;
                }
                if ($current_route === 'tag') {
                    $tag = $this->request->tag;
                    $this->page_title = $tag->title;
                    $this->title = $tag->title;
                    $this->description = __('site.seo_description');
                    $this->stop = true;
                }
                if ($current_route === 'speciality') {
                    $specialities = Cache::get('insureapi_doctors');
                    $speciality = collect($specialities['specialities'])->where('id', $this->request->id)->first();
                    if ($speciality) {
                        $this->page_title = $speciality['name'];
                        $this->description = __('site.speciality_description', ['speciality' => $speciality['name']]);
                        $category = $this->categoryRepository->getModel()->where('active', true)->where('taxonomy', Category::DOCTORS)->first();
                        $this->title = $speciality['name'];
                        $this->breadcrumbs[$level] = ['title' => $category->title, 'active' => true, 'link' => route('category', ['category' => $category->slug])];
                        $this->breadcrumbs[$level + 1] = ['title' => $speciality['name'], 'active' => true, 'link' => \route('speciality', [$category, $speciality['id']])];
                        $this->stop = true;
                    }
                }
                if ($current_route === 'doctor') {
                    $doctor = Doctor::findOrFail($this->request->id);
                    if ($doctor) {
                        $this->page_title = $doctor->name;
                        $this->title = $doctor->name;
                        $this->description = __('site.doctor_description', ['name' => $doctor->name]);
                        $category = $this->categoryRepository->getModel()->where('active', true)->where('taxonomy', Category::DOCTORS)->first();
                        $this->breadcrumbs[$level] = ['title' => $category->title, 'active' => true, 'link' => route('category', ['category' => $category->slug])];
                        $this->breadcrumbs[$level + 1] = ['title' => $doctor->speciality_title, 'active' => true, 'link' => \route('speciality', [$category, $doctor->speciality_id])];
                        $this->breadcrumbs[$level + 2] = ['title' => $doctor->name, 'active' => true, 'link' => \route('doctor', [$category, $doctor->id])];
                        $this->stop = true;
                    }
                }
                if ($current_route === 'product') {
                    $product = $this->request->product;
                    $this->page_title = $product->title;
                    if ($product->sub_title) {
                        $this->subTitle = $product->sub_title;
                    }
                    $this->title = $product->title . ($product->seo_keywords ? ' ::: ' . $product->seo_keywords : '');
                    $this->description = $product->meta_description ?: '';
                    $category = $product->categories->first();
                    if ($category->parent_id) {
                        $parent = Category::find($category->parent_id);
                        $this->breadcrumbs[$level] = ['title' => $parent->title, 'active' => false, 'link' => route('category', $parent->slug)];
                        ++$level;
                    }
                    if ($product->getFirstMediaUrl('preview')) {
                        $this->ogImage = $product->getFirstMediaUrl('preview');
                    }
                    if ($product->getFirstMedia('big_preview')) {
                        $this->image = $product->getFirstMedia('big_preview');
                    }
                    $this->breadcrumbs[$level] = ['title' => $category->title, 'active' => true, 'link' => route('category', ['category' => $category->slug])];
                    $this->breadcrumbs[$level + 1] = ['title' => $product->title, 'active' => true, 'link' => $product->link];
                    $this->stop = true;
                }
                if (in_array($current_route, ['search', 'search-other'])) {
                    $this->title = __('site.search_page_title');
                    $this->page_title = __('site.search_page_title');
                    $this->breadcrumbs[$level] = ['title' => __('site.search_page_title'), 'active' => true, 'link' => route('search')];
                    $this->stop = true;
                }
                if (count($item->children)) {
                    $this->build($item->children, $level + 1, $current_route);
                }
            }
        }

        if (!$this->stop) {
            $this->breadcrumbs = [];
            $level = 0;
            $this->buildByMenu($structure, $level, $current_route);
        }
        if ($current_route === null) {
            $this->title = __('site.title_404');
            $this->page_title = __('site.title_404');
            $this->breadcrumbs = [];
        }
    }
}
