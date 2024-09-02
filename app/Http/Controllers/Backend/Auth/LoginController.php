<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\Auth\StaffLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BackendController
{

    public function showLoginForm(Request $request): Factory|View|Application
    {
        return $this->render('backend.auth.login');
    }

    public function store(StaffLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        activity('auth')->causedBy(Auth::guard('staff')->user())->log('logged in');

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('staff')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
