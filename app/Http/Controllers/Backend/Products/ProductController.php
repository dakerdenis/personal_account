<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\ProductDataRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\FileModelRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\UsefulLinkRepositoryInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends BackendController
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private ActivityRepositoryInterface $activityRepository,
        private UsefulLinkRepositoryInterface $usefulLinkRepository,
        private ArticleRepositoryInterface $articleRepository,
        private FileModelRepositoryInterface $fileModelRepository,
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create products') || Gate::allows('edit products') || Gate::allows('delete products')), 403);
        $products = $this->productRepository->filterAndPaginate($request);

        return $this->render('backend.products.index', compact('products'));
    }

    public function store(ProductDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create products'), 403);
        try {
            $product = $this->productRepository->create($request->validated());
            $this->activityRepository->log('content', $product, ['route_name' => 'backend.products.edit', 'parameter' => 'product', 'title' => $product->title], Product::$created);
            $message = ['type' => 'Success', 'message' => 'Product has been created successfully'];
        } catch (Exception $exception) {
            Log::error('ProductController@store: ' . $exception->getMessage(), ['exception' => $exception]);
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.products.index')->with(compact('message'));
    }

    public function create(): View
    {
        abort_unless(Gate::allows('create products'), 403);
        $categories = $this->categoryRepository->where(['taxonomy' => Category::PRODUCTS]);
        $usefulLinks = $this->usefulLinkRepository->all();
        $articles = $this->articleRepository->all();
        $packages = $this->productRepository->where(['type' => Product::TYPE_PACKAGE]);
        $files = $this->fileModelRepository->all();

        return $this->render('backend.products.create', compact('categories', 'usefulLinks', 'articles', 'packages', 'files'));
    }

    public function edit(Product $product): View
    {
        abort_unless(Gate::allows('edit products'), 403);
        $categories = $this->categoryRepository->where(['taxonomy' => Category::PRODUCTS]);
        $usefulLinks = $this->usefulLinkRepository->all();
        $articles = $this->articleRepository->all();
        $packages = $this->productRepository->where(['type' => Product::TYPE_PACKAGE]);
        $files = $this->fileModelRepository->all();

        return $this->render('backend.products.create', compact('product', 'categories', 'usefulLinks', 'articles', 'packages', 'files'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless(Gate::allows('delete products'), 403);
        try {
            $title = $product->title;
            $this->productRepository->delete($product->id);
            $this->activityRepository->log('content', $product, ['title' => $title], Product::$deleted);
            $message = ['type' => 'Success', 'message' => 'Product has been deleted successfully'];
        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.products.index')->with(compact('message'));
    }

    public function update(ProductDataRequest $request, Product $product): RedirectResponse
    {
        abort_unless(Gate::allows('edit products'), 403);
        try {
            $this->productRepository->update($product->id, $request->validated());
            $this->activityRepository->log('content', $product, ['route_name' => 'backend.products.edit', 'parameter' => 'product', 'title' => $product->title], Product::$updated);
            $message = ['type' => 'Success', 'message' => 'Product has been updated successfully'];
        } catch (Exception $exception) {
            $message = ['type' => 'Danger', 'message' => $exception->getMessage()];
        }

        return redirect()->route('backend.products.index')->with(compact('message'));
    }

    public function toggleActive(Request $request, Product $product)
    {
        abort_unless(Gate::allows('edit products'), 403);
        if ($request->has('active')) {
            $active = (boolean) $request->post('active');
            $product->active = $active;
            $product->save();
            $this->activityRepository->log('content', $product, ['route_name' => 'backend.products.edit', 'parameter' => 'product', 'title' => $product->title], $active ? Product::$activated : Product::$deactivated);
        }
    }

    public function getInsuranceBlock(Request $request)
    {
        $id = Str::random(24) . time();

        return view('backend.partials.specification', compact('id'));
    }

    public function getFeatureBlock(Request $request)
    {
        $id = Str::random(24) . time();

        return view('backend.partials.description', compact('id'));
    }

    public function getFeatureLineBlock(mixed $featureId)
    {
        $id = Str::random(24) . time();

        return view('backend.partials.feature_line', compact('id', 'featureId'));
    }

    public function getFaqBlock()
    {
        $id = Str::random(24) . time();

        return view('backend.partials.faqs', compact('id'));
    }

    public function reorderView(): View
    {
        abort_unless(Gate::allows('edit products'), 403);
        $products = $this->productRepository->allNested()->toTree();

        return $this->render('backend.products.reorder', compact('products'));
    }

    public function reorder(Request $request) :bool
    {
        abort_unless(Gate::allows('edit products'), 403);

        return $this->productRepository->reorder($request);
    }
}
