<?php

namespace App\Http\Requests\Backend;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BranchDataRequest extends FormRequest
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
            'address:az' => 'nullable|string',
            '%address%' => 'sometimes|nullable',
            'work_hours:az' => 'nullable|string',
            '%work_hours%' => 'sometimes|nullable',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'active'=>'nullable',
            'delete_images' => 'array|nullable',
            'preview' => 'image|nullable',
            'preview_url' => 'string|nullable',
        ];
        return RuleFactory::make($rules, RuleFactory::FORMAT_KEY, '%', '%', [
            'ru',
            'en',
        ]);
    }
}
