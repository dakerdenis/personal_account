<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class AppLayout extends Component
{
    public function __construct(public ?string $class)
    {
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
