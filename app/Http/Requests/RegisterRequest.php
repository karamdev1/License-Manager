<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'username' => 'required|string|unique:users,username|min:8|max:50',
            'password' => 'required|string|confirmed|min:8|max:50',
            'reff' => 'required|string|max:50',
        ];
    }
}
