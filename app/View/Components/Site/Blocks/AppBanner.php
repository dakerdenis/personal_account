<?php

namespace App\View\Components\Site\Blocks;

use App\Models\Block;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBanner extends Component
{
    public ?Contact $contact;
    public function __construct(public Block $block)
    {
        $this->contact = Contact::find(1);
    }

    public function render(): View
    {
        return view('components.site.blocks.app_banner');
    }
}
