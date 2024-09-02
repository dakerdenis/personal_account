<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class SliderDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    #[ArrayShape(['name' => "string"])] public function rules(): array
    {
        return [
            'name' => 'required|string'
        ];
    }
}
