<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Site\SiteController;
use App\Http\Requests\Site\Auth\RegisterDataRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends SiteController
{
    public function register(RegisterDataRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => (int)filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->route('index');
    }
}
