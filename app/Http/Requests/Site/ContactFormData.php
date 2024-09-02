<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormData extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'message' => 'required|string',
            'company' => 'nullable|string',
            //'department_id' => 'required',
            'g-recaptcha-response' => 'required|string',
        ];
    }
}
