<?php

namespace App\View\Components\Site;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class UserProfileMenu extends Component
{
    public User $user;

    public function __construct(public ?string $type)
    {
        $this->user = Auth::user();
    }

    public function render(): View
    {
        return view('components.site.user-profile-menu');
    }
}
