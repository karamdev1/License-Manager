<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSaldoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return require_ownership(0, 1, 1);
    }

    public function rules(): array
    {
        return [
            'user_id'  => 'required|string|min:36|max:36|exists:users,user_id',
            'saldo'    => 'required|integer|min:1|max:2000000000',
        ];
    }
}
