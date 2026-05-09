<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
             'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
        'password.min'      => 'Password must be at least 8 characters.',
        ];
    }
}