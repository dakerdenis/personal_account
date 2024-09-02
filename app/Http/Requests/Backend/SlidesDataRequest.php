<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SlidesDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'delete_slides' => 'nullable|array',
            'slides' => 'nullable|array',
            'slides.*.title:az' => 'nullable|string',
            'slides.*.%title%' => 'sometimes|nullable',
            'slides.*.button_text:az' => 'nullable|string',
            'slides.*.%button_text%' => 'sometimes|nullable',
            'slides.*.link:az' => 'nullable|string',
            'slides.*.%link%' => 'sometimes|nullable',
            'slides.*.description:az' => 'nullable|string',
            'slides.*.%description%' => 'sometimes|nullable',
            'slides.*.preview' => 'nullable|image',
            'delete_links' => 'nullable|array',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en'
        ]);
    }
}
