<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class MainPageBlocksDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    #[ArrayShape(['blocks' => "string"])] public function rules(): array
    {
        return [
            'blocks' => 'array|nullable'
        ];
    }
}
