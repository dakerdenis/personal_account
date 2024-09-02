<?php

namespace App\View\Components\Site\Partials;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class MainPageBanner extends Component
{
    public function __construct(public Collection $slides)
    {
    }

    public function render(): View
    {
        return view('components.site.partials.main-page-banner');
    }
}
