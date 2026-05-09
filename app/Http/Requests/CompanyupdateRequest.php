<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyupdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'industry'       => 'required|string|max:255',
            'website'        => 'nullable|url|max:255',
            'owner_name'     => 'required|string|max:255',
            'owner_password' => 'nullable|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'The company name is required.',
            'name.string'            => 'The company name must be a string.',
            'name.max'               => 'The company name may not be greater than 255 characters.',
            'address.required'       => 'The company address is required.',
            'address.string'         => 'The company address must be a string.',
            'address.max'            => 'The company address may not be greater than 255 characters.',
            'industry.required'      => 'The company industry is required.',
            'industry.string'        => 'The company industry must be a string.',
            'industry.max'           => 'The company industry may not be greater than 255 characters.',
            'website.url'            => 'The company website must be a valid URL.',
            'website.max'            => 'The company website may not be greater than 255 characters.',
            'owner_name.required'    => 'The owner name is required.',
            'owner_name.string'      => 'The owner name must be a string.',
            'owner_name.max'         => 'The owner name may not be greater than 255 characters.',
            'owner_password.string'  => 'The owner password must be a string.',
            'owner_password.min'     => 'The owner password must be at least 8 characters.',
        ];
    }
}