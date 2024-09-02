<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection as LaravelCollection;
use Illuminate\View\Component;
use Kalnoy\Nestedset\Collection;

class OurProducts extends Component
{
    public Collection|LaravelCollection $categories;

    public function __construct(public Block $block, private CategoryRepositoryInterface $categoryRepository)
    {
        $this->categories = $this->categoryRepository->getCategoriesForBlock();
    }
    public function render(): View
    {
        return view('components.site.blocks.sale');
    }
}
