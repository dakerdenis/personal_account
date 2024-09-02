<?php

namespace App\Http\Requests\Site\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'unique:users,phone', function($attribute, $value, $fail) {
                if (!preg_match('/^994\d{9}$/', (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT))) {
                    $fail(__('site.wrong_number_format'));
                }
            }],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }
}
