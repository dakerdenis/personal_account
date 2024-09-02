<?php

namespace App\Http\Controllers\Backend\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ArticleDataRequest;
use App\Models\Article;
use App\Models\Category;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\GalleryRepositoryInterface;
use App\Repository\UsefulLinkRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private ArticleRepositoryInterface  $articleRepository,
        private GalleryRepositoryInterface  $galleryRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private UsefulLinkRepositoryInterface $usefulLinkRepository,
        private FileModelRepositoryInterface $fileModelRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create articles') || Gate::allows('edit articles') || Gate::allows('delete articles')), 403);
        $categories = $this->categoryRepository->all();
        $articles = $this->articleRepository->filterAndPaginate($request);

        return $this->render('backend.articles.index', compact('articles', 'categories'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create articles'), 403);
        $galleries = $this->galleryRepository->all();
        $categories = $this->categoryRepository->whereIn('taxonomy', [Category::BLOG, Category::SPECIAL_OFFERS]);
        $usefulLinks = $this->usefulLinkRepository->all();
        $files = $this->fileModelRepository->all();

        return $this->render('backend.articles.create', compact('galleries', 'categories', 'usefulLinks', 'files'));
    }

    public function store(ArticleDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create articles'), 403);
        if ($article = $this->articleRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Article has been created successfully'];
            $this->activityRepository->log('content', $article, ['route_name' => 'backend.articles.edit', 'parameter' => 'article', 'title' => $article->title], Article::$created);
        }
        return redirect()->route('backend.articles.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Request $request, Article $article): View
    {
        abort_unless(Gate::allows('edit articles'), 403);
        $galleries = $this->galleryRepository->all();
        $categories = $this->categoryRepository->whereIn('taxonomy', [Category::BLOG, Category::SPECIAL_OFFERS]);
        $usefulLinks = $this->usefulLinkRepository->all();
        $files = $this->fileModelRepository->all();

        return $this->render('backend.articles.create', compact('galleries', 'article', 'categories', 'files', 'usefulLinks'));
    }

    public function update(ArticleDataRequest $request, Article $article): RedirectResponse
    {
        abort_unless(Gate::allows('edit articles'), 403);
        if ($this->articleRepository->update($article->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Article has been updated successfully'];
            $this->activityRepository->log('content', $article, ['route_name' => 'backend.articles.edit', 'parameter' => 'article', 'title' => $article->title], Article::$updated);
        }
        return redirect()->route('backend.articles.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(Request $request, Article $article): RedirectResponse
    {
        abort_unless(Gate::allows('delete articles'), 403);
        $title = $article->title;
        if ($this->articleRepository->delete($article->id)) {
            $message = ['type' => 'Success', 'message' => 'Article has been deleted successfully'];
            $this->activityRepository->log('content', $article, ['title' => $title], Article::$deleted);
        }
        return redirect()->route('backend.articles.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function toggleActive(Request $request, Article $article)
    {
        abort_unless(Gate::allows('edit articles'), 403);
        if ($request->has('active')) {
            $active = (boolean)$request->post('active');
            $this->articleRepository->update($article->id, ['active' => $active]);
            $this->activityRepository->log('content', $article, ['route_name' => 'backend.articles.edit', 'parameter' => 'article', 'title' => $article->title], $active ? Article::$activated : Article::$deactivated);
        }
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit articles'), 403);
        $articles = $this->articleRepository->allNested();
        $articles = $articles->filter(fn($article) => $article->categories()->first()->taxonomy === Category::SPECIAL_OFFERS)->toTree();

        return $this->render('backend.articles.reorder', compact('articles'));
    }

    public function reorder(Request $request): bool
    {
        abort_unless(Gate::allows('edit articles'), 403);

        return $this->articleRepository->reorder($request);
    }
}
