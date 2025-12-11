<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return require_ownership(1, 1, 1);
    }

    public function rules(): array
    {
        return [
            'user_id'  => 'required|string|min:36|max:36|exists:users,user_id',
        ];
    }
}
