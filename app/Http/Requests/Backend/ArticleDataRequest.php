<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ArticleDataRequest extends FormRequest
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
            'short_description:az' => 'nullable|string',
            '%short_description%' => 'sometimes|nullable',
            'bottom_text:az' => 'nullable|string',
            '%bottom_text%' => 'sometimes|nullable',
            'seo_keywords:az' => 'nullable|string',
            '%seo_keywords%' => 'sometimes|nullable',
            'date' => 'nullable|date',
            'slug' => 'required_without:external_link' . (request()->routeIs('backend.articles.store') ? '|unique:articles' : ''),
            'gallery_id' => 'nullable|int',
            'category_id' => 'required|int',
            'active'=>'nullable',
            'archive'=>'nullable',
            'delete_images' => 'array|nullable',
            'preview' => 'image|nullable',
            'preview_url' => 'string|nullable',
            'preview_center' => 'image|nullable',
            'preview_url_center' => 'string|nullable',
            'youtube_tag' => 'string|nullable',
            'files' => 'array|nullable',
            'files.*' => 'int|exists:files,id',
            'useful_links' => 'array|nullable',
            'useful_links.*' => 'int|exists:useful_links,id',
            'end_date' => 'date|nullable',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
