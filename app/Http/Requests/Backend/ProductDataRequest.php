<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ProductDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title:az' => 'required|string',
            '%title%' => 'string|nullable',
            'sub_title:az' => 'string|nullable',
            '%sub_title%' => 'string|nullable',
            'description:az' => 'string|nullable',
            '%description%' => 'string|nullable',
            'meta_title:az' => 'string|nullable',
            '%meta_title%' => 'string|nullable',
            'meta_description:az' => 'string|nullable',
            '%meta_description%' => 'string|nullable',
            'seo_keywords:az' => 'string|nullable',
            '%seo_keywords%' => 'string|nullable',
            'statistics:az' => 'array|nullable',
            '%statistics%' => 'array|nullable',
            'banner:az' => 'array|nullable',
            '%banner%' => 'array|nullable',
            'calculator_title:az' => 'string|nullable',
            '%calculator_title%' => 'string|nullable',
            'form_title:az' => 'string|nullable',
            '%form_title%' => 'string|nullable',
            'insurance_conditions_title:az' => 'string|nullable',
            '%insurance_conditions_title%' => 'string|nullable',
            'files_title:az' => 'string|nullable',
            '%files_title%' => 'string|nullable',
            'packages_title:az' => 'string|nullable',
            '%packages_title%' => 'string|nullable',
            'packages_description:az' => 'string|nullable',
            '%packages_description%' => 'string|nullable',
            'preview' => 'image|nullable',
            'preview_url' => 'string|nullable',
            'small_preview' => 'image|nullable',
            'small_preview_url' => 'string|nullable',
            'banner_preview' => 'image|nullable',
            'banner_preview_url' => 'string|nullable',
            'big_preview' => 'image|nullable',
            'big_preview_url' => 'string|nullable',
            'category_id' => 'required|integer|exists:categories,id',
            'slug' => 'required|string',
            'type' => 'nullable|string',
            'form' => 'nullable|string',
            'calculator' => 'nullable|string',
            'insuranceBlocks' => 'array|nullable',
            'featureBlocks' => 'array|nullable',
            'faqs' => 'array|nullable',
            'useful_links' => 'array|nullable',
            'special_offers' => 'array|nullable',
            'packages' => 'array|nullable',
            'active' => 'boolean',
            'delete_insuranceBlocks' => 'array|nullable',
            'delete_feature_lines' => 'array|nullable',
            'delete_features' => 'array|nullable',
            'delete_faqs' => 'array|nullable',
            'delete_images' => 'array|nullable',
            'files' => 'array|nullable',
            'files.*' => 'int|exists:files,id',
            'form_receivers' => 'string|nullable',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
