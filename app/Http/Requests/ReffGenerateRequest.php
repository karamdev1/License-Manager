<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReffGenerateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return require_ownership(0, 1, 1);;
    }

    public function rules(): array
    {
        return [
            'status'   => 'required|in:Active,Inactive',
        ];
    }
}
