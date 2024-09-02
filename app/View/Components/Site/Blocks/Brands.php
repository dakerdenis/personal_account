<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use App\Repository\BrandRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Kalnoy\Nestedset\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Brands extends Component
{
    public Collection|EloquentCollection $brands;

    public function __construct(Block $block, private BrandRepositoryInterface $brandRepository)
    {
        $this->brands = $this->brandRepository->activeOrderedBy(['title']);
    }

    public function render(): View
    {
        return view('components.site.blocks.brands');
    }
}
