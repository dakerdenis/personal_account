<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BlockDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'data:az' => 'nullable|array',
            '%data%' => 'sometimes|nullable',
            'title:az' => 'required|string',
            '%title%' => 'sometimes|nullable',
            'delete_images' => 'array|nullable',
            'preview' => 'image|nullable',
            'preview_url' => 'string|nullable',
            'preview_az' => 'image|nullable',
            'preview_url_az' => 'string|nullable',
            'preview_ru' => 'image|nullable',
            'preview_url_ru' => 'string|nullable',
            'preview_right' => 'image|nullable',
            'preview_url_right' => 'string|nullable',
            'preview_left' => 'image|nullable',
            'preview_url_left' => 'string|nullable',
            'preview_center' => 'image|nullable',
            'preview_url_center' => 'string|nullable',
            'images' => 'nullable|array|min:1|max:20',
            'meta' => 'nullable|array',
            'type' => 'required',
            'unique' => 'nullable',
            'video' => 'file|nullable'
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
