<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsefulLinkDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'title:az' => 'required|string',
            '%title%' => 'sometimes|nullable',
            'active'=>'nullable',
            'delete_images' => 'array|nullable',
            'preview' => 'image|nullable',
            'preview_url' => 'string|nullable',
            'link' => 'required|string',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
