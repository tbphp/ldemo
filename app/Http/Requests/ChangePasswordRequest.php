<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_password' => 'required|password',
            'password' => 'required|confirmed|different:old_password|min:6|max:18',
            'password_confirmation' => 'required',
        ];
    }
}
