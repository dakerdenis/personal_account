<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Site\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends SiteController
{
    public function create()
    {
        return $this->render('site.auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('success', __('site.password_reset_link_sent'))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __('site.user_not_found')]);
    }
}
