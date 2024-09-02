<?php

namespace App\View\Components\Site\Partials;

use App\Models\Category;
use App\Models\Type;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\GeneralSettingRepositoryInterface;
use App\Repository\NavigationRepositoryInterface;
use App\Repository\TypeRepositoryInterface;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kalnoy\Nestedset\Collection;

class Search extends Component
{
    public Collection $menu;
    public Collection $types;
    public Collection $categories;
    public GeneralSettings $settings;
    public bool $showFlatBanner = false;
    public bool $showBanner = true;

    public function __construct(
        private NavigationRepositoryInterface     $navigationRepository,
        private GeneralSettingRepositoryInterface $settingRepository,
        private TypeRepositoryInterface           $typeRepository,
        private CategoryRepositoryInterface       $categoryRepository,
    )
    {
        $this->menu = $this->navigationRepository->getNavigationMenuItems('main_navigation');
        $this->settings = $this->settingRepository->get();
        $this->types = $this->typeRepository->allActiveNested();
        $this->categories = $this->categoryRepository->allActiveNested();
//        $this->showFlatBanner = !Route::is('index');
        $this->showBanner = !Route::is('add-advert');
    }

    public function getSelectedCategory(): ?int
    {
        $routeName = Route::getCurrentRoute()?->getName();
        if (!in_array($routeName, ['category', 'advert-list', 'map'])) {
            return null;
        }

        if ($routeName === 'map') {
            return $this->categoryRepository->find(request()->get('category_id'))?->id;
        }

        return Route::current()?->parameter('category')?->id;
    }

    public function getSelectedType(): ?int
    {
        $routeName = Route::getCurrentRoute()?->getName();
        if (!in_array($routeName, ['advert-list', 'map'])) {
            return null;
        }

        if ($routeName === 'map') {
            return $this->typeRepository->find(request()->get('type_id'))?->id;
        }

        return Route::current()?->parameter('type')?->id;
    }

    public function getDefaultAction(): string
    {
        if (Route::current()?->parameter('type') instanceof Type) {
            return route('advert-list', ['type' => Route::current()->parameter('type')?->slug, 'category' => Route::current()->parameter('category')?->slug]);
        }

        if (Route::current()?->parameter('category') instanceof Category) {
            return route('category', ['category' => Route::current()->parameter('category')?->slug]);
        }

        return route('advert-list');
    }

    public function render(): View
    {
        return view('components.site.partials.search');
    }
}
