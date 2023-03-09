<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => 'required|string|size:42|regex:/^0x[a-fA-F\d]{40}$/',
            'sign' => 'required|string|size:132|regex:/^0x[a-fA-F\d]{130}$/',
        ];
    }
}
