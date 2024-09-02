<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use App\Models\Category;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\PartnerRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Partners extends Component
{
    public Collection $partners;
    public Category $partnerCategory;

    public function __construct(public Block $block, protected PartnerRepositoryInterface $partnerRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->partners = $this->partnerRepository->forBlock();
        $this->partnerCategory = $categoryRepository->getModel()->where('taxonomy', Category::PARTNERS)->first();
    }

    public function render(): View
    {
        return view('components.site.blocks.partners');
    }
}
