<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryDataRequest extends FormRequest
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
            'description:az' => 'nullable|string',
            '%description%' => 'sometimes|nullable',
            'meta_description:az' => 'nullable|string',
            '%meta_description%' => 'sometimes|nullable',
            'seo_keywords:az' => 'nullable|string',
            '%seo_keywords%' => 'sometimes|nullable',
            'slug' => 'required' . (request()->routeIs('backend.categories.store') ? '|unique:categories' : ''),
            'active'=>'nullable',
            'parent_id' => 'nullable|integer',
            'type_ids' => 'nullable|array',
            'type_ids.*' => 'int|exists:types,id',
            'taxonomy' => 'required|string',
            'preview' => 'nullable|image',
            'preview_url' => 'nullable|string',
            'delete_images' => 'array|nullable',
            'delete_blocks' => 'array|nullable',
            'image' => 'array|nullable',
            'show_date_on_articles'=>'nullable',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
