<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VacancyDataRequest extends FormRequest
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
            'conditions:az' => 'nullable|string',
            '%conditions%' => 'sometimes|nullable',
            'requirements:az' => 'nullable|string',
            '%requirements%' => 'sometimes|nullable',
            'contacts:az' => 'nullable|string',
            '%contacts%' => 'sometimes|nullable',
            'date' => 'required|date',
            'slug' => 'required|string',
            'vacancy_place_title_id' => 'required|int',
            'active'=>'nullable',
            'files' => 'array|nullable',
            'files.*' => 'int|exists:files,id',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en'
        ]);
    }
}
