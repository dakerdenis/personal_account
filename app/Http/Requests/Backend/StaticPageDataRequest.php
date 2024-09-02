<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StaticPageDataRequest extends FormRequest
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
            'subtitle:az' => 'nullable|string',
            '%subtitle%' => 'sometimes|nullable',
            'seo_keywords:az' => 'nullable|string',
            '%seo_keywords%' => 'sometimes|nullable|string',
            'slug' => 'required|string' . (request()->routeIs('backend.static_pages.store') ? '|unique:static_pages' : ''),
            'active'=>'nullable',
            'preview' => 'nullable|image',
            'preview_url' => 'nullable|string',
            'delete_images' => 'array|nullable',
            'gallery_id' => 'nullable|int',
            'bottom_text:az' => 'nullable|string',
            '%bottom_text%' => 'sometimes|nullable',
            'youtube_tag' => 'string|nullable',
            'files' => 'array|nullable',
            'files.*' => 'int|exists:files,id',
            'useful_links' => 'array|nullable',
            'useful_links.*' => 'int|exists:useful_links,id',
            'form' => 'nullable|string',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
