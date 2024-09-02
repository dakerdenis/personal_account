<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PartnerDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'title:az'      => 'required|string',
            '%title%'       => 'sometimes|nullable',
            'link:az'       => 'nullable|string',
            '%link%'        => 'sometimes|nullable',
            'active'        => 'nullable',
            'show_in_block' => 'nullable',
            'delete_images' => 'array|nullable',
            'preview'       => 'image|nullable',
            'preview_url'   => 'string|nullable',
            'review'        => 'nullable|file',
        ];

        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
