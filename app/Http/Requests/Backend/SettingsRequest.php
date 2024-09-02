<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'complaintFormReceivers'    => 'string|required',
            'contactsFormReceivers'     => 'string|required',
            'vacancyFormReceivers'      => 'string|required',
        ];
    }
}
