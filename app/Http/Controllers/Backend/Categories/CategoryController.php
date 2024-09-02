<?php

namespace App\Http\Controllers\Backend\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryDataRequest;
use App\Models\Category;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private CategoryRepositoryInterface $categoryRepository
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create categories') || Gate::allows('edit categories') || Gate::allows('delete categories')), 403);
        $categories = $this->categoryRepository->filterAndPaginate($request);
        return $this->render('backend.categories.index', compact('categories'));
    }

    public function create(Request $request): View
    {
        abort_unless(Gate::allows('create categories'), 403);
        $categories = $this->categoryRepository->where(['active' => 1])->toTree();
        $taxonomies = Category::$terms;
        return $this->render('backend.categories.create', compact('categories', 'taxonomies'));
    }

    public function store(CategoryDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create categories'), 403);
        if ($category = $this->categoryRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Category has been created successfully'];
            $this->activityRepository->log('content', $category, ['route_name' => 'backend.categories.edit', 'parameter' => 'category', 'title' => $category->title], Category::$created);
        }
        return redirect()->route('backend.categories.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Category $category): View
    {
        abort_unless(Gate::allows('edit categories'), 403);
        $categories = $this->categoryRepository->where([['taxonomy', $category->taxonomy], ['id', '!=', $category->id]])->toTree();
        $taxonomies = Category::$terms;
        return $this->render('backend.categories.create', compact('categories', 'taxonomies', 'category'));
    }

    public function update(CategoryDataRequest $request, Category $category): RedirectResponse
    {
        abort_unless(Gate::allows('edit categories'), 403);
        if ($this->categoryRepository->update($category->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Category has been updated successfully'];
            $this->activityRepository->log('content', $category, ['route_name' => 'backend.categories.edit', 'parameter' => 'category', 'title' => $category->title], Category::$updated);
        }
        return redirect()->route('backend.categories.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        abort_unless(Gate::allows('delete categories'), 403);
        $title = $category->title;
        if ($this->categoryRepository->delete($category->id)) {
            $message = ['type' => 'Success', 'message' => 'Category has been deleted successfully'];
            $this->activityRepository->log('content', $category, ['title' => $title], Category::$deleted);
        }
        return redirect()->route('backend.categories.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function toggleActive(Request $request, Category $category)
    {
        if ($request->has('active')) {
            $active = (boolean)$request->post('active');
            $this->categoryRepository->update($category->id, ['active' => $active]);
            $this->activityRepository->log('content', $category, ['route_name' => 'backend.categories.edit', 'parameter' => 'category', 'title' => $category->title], $active ? Category::$activated : Category::$deactivated);
        }
    }

    public function reorderView(Request $request): View
    {
        $categories = $this->categoryRepository->allNested()->toTree();

        return $this->render('backend.categories.reorder', compact('categories'));
    }

    public function reorder(Request $request): bool
    {
        return $this->categoryRepository->reorder($request);
    }

}
