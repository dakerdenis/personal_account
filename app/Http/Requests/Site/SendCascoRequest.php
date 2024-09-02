<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class SendCascoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'brand' => 'required|int',
            'productionYear' => 'required|int',
            'marketPrice' => 'required|numeric',
            'repairShop' => 'required|int',
            'franchise' => 'required|int',
            'driver' => 'required|int',
            //'installment' => 'required|int',
            //'bonus' => 'required|int',
            'fullname' => 'required|string',
            'pinCode' => 'required|string',
            'phoneNumber' => 'required|string',
            'email' => 'required|string',
            'idCardFront' => 'required|file|max:3200',
            'idCardBack' => 'required|file|max:3200',
            'texPassportFront' => 'required|file|max:3200',
            'texPassportBack' => 'required|file|max:3200',
            'driveLicenseFront' => 'required|file|max:3200',
            'driveLicenseBack' => 'required|file|max:3200',
            'etibarnameFront' => 'required|file|max:3200',
            'etibarnameBack' => 'required|file|max:3200',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
