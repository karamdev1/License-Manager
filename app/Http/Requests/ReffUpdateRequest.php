<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReffUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return require_ownership(0, 1, 1);
    }

    public function rules(): array
    {
        return [
            'edit_id'  => 'required|string|min:36|max:36|exists:referrable_codes,edit_id',
            'status'   => 'required|in:Active,Inactive',
        ];
    }
}
