<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class VacancyData extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'education' => 'required|string',
            'cv' => 'file|required',
            'vacancy_id' => 'required|integer|exists:vacancies,id',
            'g-recaptcha-response' => 'required|string',
        ];
    }
}
