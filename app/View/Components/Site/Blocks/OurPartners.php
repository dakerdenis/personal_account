<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use App\Models\Category;
use App\Repository\BrandRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\LocationRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection as LaravelCollection;
use Illuminate\View\Component;
use Kalnoy\Nestedset\Collection;

class OurPartners extends Component
{
    public Collection|LaravelCollection $partners;
    public Category $partnerCategory;

    public function __construct(public Block $block, private BrandRepositoryInterface $brandRepository, private CategoryRepositoryInterface $categoryRepository)
    {
        $this->partners = $this->brandRepository->allActiveNested()->take(6);
        $this->partnerCategory = $this->categoryRepository->getModel()->where('taxonomy', Category::PARTNERS)->first();
    }
    public function render(): View
    {
        return view('components.site.blocks.locations');
    }
}
