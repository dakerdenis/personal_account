<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class StaffDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    #[ArrayShape(['name' => "string", 'email' => "string", 'password' => "string", 'roles' => "string"])] public function rules(): array
    {
        return [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'min:8|string' . (request()->routeIs('backend.staff.store') ? '|required' : '|nullable'),
            'roles' => 'array|nullable'
        ];
    }
}
