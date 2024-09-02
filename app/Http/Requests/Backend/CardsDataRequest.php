<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CardsDataRequest extends FormRequest
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
            'data:az' => 'nullable|array',
            '%data%' => 'sometimes|nullable',
            'type' => 'required|string',
            'repeatable' => 'array|nullable',
            'meta' => 'array|nullable',
            'delete_repeatables' => 'array|nullable',
            'media_collection_name' => 'nullable|string',
            'stat' => 'array|nullable',
            'delete_stat' => 'array|nullable',
            'delete_stat_info' => 'array|nullable',
        ];

        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'en',
            'ru',
        ]);
    }
}
