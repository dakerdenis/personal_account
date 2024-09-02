<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintFormData extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => 'required|string',
            'secondName' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'message' => 'required|string',
            'personalId' => 'required|string',
            'g-recaptcha-response' => 'required|string',
        ];
    }
}
