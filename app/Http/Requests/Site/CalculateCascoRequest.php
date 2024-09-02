<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CalculateCascoRequest extends FormRequest
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
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
