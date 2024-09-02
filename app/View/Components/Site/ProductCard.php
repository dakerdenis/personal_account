<?php

namespace App\View\Components\Site;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public ?string $frontImage = null;
    public ?string $backImage = null;

    public function __construct(
        public Product $product,
        public string $class = 'col-xl-3 col-6 col-grid-box',
        public bool $canDisappear = false,
        public bool $showWrapper = true,
    )
    {
        $media = $product->getMedia('gallery');
        $this->frontImage = $media[0]->getUrl();
        $this->backImage = ($media[1] ?? null) ? $media[1]->getUrl() : null;
    }

    public function render(): Application|Factory|View
    {
        return view('components.site.product-card');
    }
}
