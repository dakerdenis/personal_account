<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CaseHappenedFormData extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'surname' => 'required|string',
            'policy_number' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'insurance_type_id' => 'required|string',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|string',
        ];
    }
}
