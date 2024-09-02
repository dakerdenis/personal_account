<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class BasicFormData extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName' => 'required|string',
            'phone' => 'required|string',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|string',
        ];
    }
}
