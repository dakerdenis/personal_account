<?php

namespace App\Http\Controllers\Backend\Blocks;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\BlockDataRequest;
use App\Http\Requests\Backend\CardsDataRequest;
use App\Http\Requests\Backend\MainPageBlocksDataRequest;
use App\Models\Block;
use App\Repository\ActivityRepositoryInterface;
use App\Repository\BlockRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BlockController extends BackendController
{

    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private BlockRepositoryInterface    $blockRepository,
        private ProductRepositoryInterface $productRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        abort_unless((Gate::allows('create blocks') || Gate::allows('edit blocks') || Gate::allows('delete blocks')), 403);
        $blocks = $this->blockRepository->filterAndPaginate($request);

        return $this->render('backend.blocks.index', compact('blocks'));
    }

    public function selectType(Request $request): View
    {
        $types = Block::$types;

        return $this->render('backend.blocks.select_type', compact('types'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        abort_unless(Gate::allows('create blocks'), 403);

        if (!$request->has('type')) return redirect()->route('backend.blocks.select_type')->send();
        $type = $request->get('type');
        if ($block = $this->blockRepository->whereFirst([['type', $request->get('type')], ['unique', true]])) return redirect()->route('backend.blocks.edit', ['block' => $block->id]);
        $variables = match ($type){
            default => [],
        };

        return $this->render('backend.blocks.types.' . $type, compact('variables') + ['type' => $request->get('type')]);
    }

    public function store(BlockDataRequest $request): RedirectResponse
    {
        abort_unless(Gate::allows('create blocks'), 403);
        if ($block = $this->blockRepository->create($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Block has been created successfully'];
            $this->activityRepository->log('content', $block, ['route_name' => 'backend.blocks.edit', 'parameter' => 'block', 'title' => $block->title], Block::$created);
        }

        return redirect()->route('backend.blocks.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function edit(Request $request, Block $block): View
    {
        abort_unless(Gate::allows('edit blocks'), 403);
        $type = $block->type;
        $variables = match ($type){
            default => [],
        };

        return $this->render('backend.blocks.types.' . $type, compact('block', 'variables'));
    }

    public function update(Request $request, Block $block): RedirectResponse
    {
        abort_unless(Gate::allows('edit blocks'), 403);
        $data = $request->except(['_method', '_token']);
        if ($this->blockRepository->update($block->id, $data)) {
            $message = ['type' => 'Success', 'message' => 'Block has been updated successfully'];
            $this->activityRepository->log('content', $block, ['route_name' => 'backend.blocks.edit', 'parameter' => 'block', 'title' => $block->title], Block::$updated);
        }
        return redirect()->route('backend.blocks.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function selectBlockLine(Request $request): View
    {
        $id = Str::random() . rand(1, 999) . time();
        return $this->render('backend.partials.select_block', compact('id'));
    }

    public function mainPageBlocks(Request $request): View
    {
        $blocks = $this->blockRepository->getPageBlocks('main_page')->pluck('block_id')->toArray();
        $title = 'Update Main Page Blocks';
        $route = 'backend.blocks.main_page_blocks';

        return $this->render('backend.blocks.main_page', compact('blocks', 'route', 'title'));
    }

    public function updateMainPageBlocks(MainPageBlocksDataRequest $request): RedirectResponse
    {
        if ($this->blockRepository->updatePageBlocks($request->validated(), 'main_page')) {
            $message = ['type' => 'Success', 'message' => 'Main Page blocks has been updated successfully'];

        }
        return redirect()->route('backend.blocks.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function categoryBlocks(Request $request): View
    {
        $blocks = $this->blockRepository->getPageBlocks('category')->pluck('block_id')->toArray();
        $title = 'Update Category Blocks';
        $route = 'backend.blocks.category_blocks';

        return $this->render('backend.blocks.main_page', compact('blocks', 'route', 'title'));
    }

    public function updateCategoryBlocks(MainPageBlocksDataRequest $request): RedirectResponse
    {
        if ($this->blockRepository->updatePageBlocks($request->validated(), 'category')) {
            $message = ['type' => 'Success', 'message' => 'Category blocks has been updated successfully'];

        }
        return redirect()->route('backend.blocks.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function searchBlock(Request $request): JsonResponse
    {
        if ($request->has('search')) {
            $search = $request->get('search');
            $blocks = Block::whereTranslationLike('title', "%$search%", 'az');
            if ($request->get('type') === 'hotline') {
                $blocks = $blocks->where('type', 'hotlines');
            }
            $blocks = $blocks->get();
            $data = [];
            foreach ($blocks as $block) {
                $data[$block->id]['value'] = $block->id;
                $data[$block->id]['display'] = $block->title;
            }
            return response()->json($data);
        }
        return response()->json([]);
    }

    public function destroy(Request $request, Block $block): RedirectResponse
    {
        abort_unless(Gate::allows('delete blocks'), 403);
        $title = $block->title;
        if (!$block->unique) {
            if ($this->blockRepository->delete($block->id)) {
                $message = ['type' => 'Success', 'message' => 'Block has been deleted successfully'];
                $this->activityRepository->log('content', $block, ['title' => $title], Block::$deleted);
            }
        }
        return redirect()->route('backend.blocks.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
    public function storeCards(CardsDataRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $view = 'backend.blocks.index';
        if ($block = $this->blockRepository->createRounds($data)) {
            if ($block->type === 'hotlines') $view = 'backend.blocks.hotlines';
            $message = ['type' => 'Success', 'message' => 'Block has been created successfully'];
            $this->activityRepository->log('content', $block, ['route_name' => 'backend.blocks.edit', 'parameter' => 'block', 'title' => $block->title], Block::$created);
        }
        return redirect()->route($view ?? 'backend.blocks.index')->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

    public function updateCards(CardsDataRequest $request, Block $block): RedirectResponse
    {
        $data = $request->validated();
        $view = 'backend.blocks.index';
        if ($block->type === 'hotlines') $view = 'backend.blocks.hotlines';
        if ($block = $this->blockRepository->updateRounds($block->id, $data)) {
            $message = ['type' => 'Success', 'message' => 'Block has been updated successfully'];
            $this->activityRepository->log('content', $block, ['route_name' => 'backend.blocks.edit', 'parameter' => 'block', 'title' => $block->title], Block::$updated);
        }
        return redirect()->route($view)->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }
    public function addCard(Request $request): View
    {
        $id = Str::random() . rand(1, 999) . time();
        $view = 'backend.partials.card';
        if ($request->post('type')) {
            match ($request->post('type')) {
                "simple" => $view = 'backend.partials.card',
                "hotline" => $view = 'backend.partials.hotline',
            };
        }
        return $this->render($view, compact('id'));
    }
    public function addCardLink(Request $request): View
    {
        $id = Str::random() . rand(1, 999) . time();
        $view = 'backend.partials.card_link';

        return $this->render($view, compact('id'));
    }
    public function addExtendedStat(): View
    {
        $id = Str::random() . rand(1, 999) . time();

        return $this->render('backend.partials.stat', compact('id'));
    }
    public function addExtendedStatInfo(Request $request): View
    {
        $id = Str::random() . rand(1, 999) . time();
        $statId = $request->input('statId');

        return $this->render('backend.partials.stat_info', compact('id', 'statId'));
    }

    public function getProductBlock()
    {
        $id = Str::random(24) . time();
        $products = $this->productRepository->all();

        return view('backend.partials.product_block', compact('id', 'products'));
    }
}
