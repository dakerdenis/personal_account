<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('site.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:24'],
            'last_name' => ['required', 'string', 'max:24'],
            'email' => ['required', 'string', 'email', 'max:64', 'unique:users'],
            'phone' => ['required', 'unique:users,phone', function($attribute, $value, $fail) {
                if (!preg_match('/^994\d{9}$/', (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT))) {
                    $fail(__('site.wrong_number_format'));
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => (int)filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('index');
    }
}
