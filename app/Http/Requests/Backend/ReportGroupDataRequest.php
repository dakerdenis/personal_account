<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReportGroupDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'title:az'       => 'required|string',
            '%title%'        => 'sometimes|nullable',
            'active'         => 'nullable',
            'report_year_id' => 'required|exists:report_years,id',
            'reports'        => 'array|nullable',
        ];

        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
