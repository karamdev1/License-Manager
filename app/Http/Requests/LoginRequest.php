<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:8|max:50',
            'stay_log' => 'in:1,0',
        ];
    }
}
