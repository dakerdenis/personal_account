<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ContactsDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title:az' => 'nullable|nullable',
            '%title%' => 'sometimes|nullable',
            'sub_title:az' => 'nullable|nullable',
            '%sub_title%' => 'sometimes|nullable',
            'description:az' => 'nullable|nullable',
            '%description%' => 'sometimes|nullable',
            'address:az' => 'nullable|nullable',
            '%address%' => 'sometimes|nullable',
            'working_hours:az' => 'nullable|nullable',
            '%working_hours%' => 'sometimes|nullable',
            'phones' => 'string|nullable',
            'email' => 'string|nullable',
            'short_number' => 'string|nullable',
            'latitude' => 'string|nullable',
            'longitude' => 'string|nullable',
            'social_networks' => 'array|nullable',
            'social_networks.*' => 'string|nullable',
            'google_play_link' => 'string|nullable',
            'app_store_link' => 'string|nullable',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
