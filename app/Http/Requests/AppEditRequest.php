<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'edit_id' => 'required|string|min:10|max:36',
        ];
    }
}
