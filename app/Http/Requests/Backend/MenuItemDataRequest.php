<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MenuItemDataRequest extends FormRequest
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
            'sub_title:az' => 'nullable|string',
            '%sub_title%' => 'sometimes|nullable',
            'seo_keywords:az' => 'nullable|string',
            '%seo_keywords%' => 'sometimes|nullable',
            'slug' => 'required|string',
            'active'=>'nullable',
            'is_mega_menu'=>'nullable',
            'preview' => 'image|nullable',
            'preview_url' => 'string|nullable',
            'parent_id' => 'nullable|integer',
            'delete_images' => 'array|nullable',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
