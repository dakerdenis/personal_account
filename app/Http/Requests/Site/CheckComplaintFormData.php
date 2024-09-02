<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CheckComplaintFormData extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personalId' => 'required|string',
            'complaintId' => 'required|string',
        ];
    }
}
