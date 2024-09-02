<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Statistics extends Component
{
    public function __construct(public Block $block)
    {

    }
    public function render(): View
    {
        return view('components.site.blocks.zig-zag-block');
    }
}
