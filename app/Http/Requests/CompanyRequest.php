<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  true;  
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
         'name' => 'required|string|max:255|unique:companies,name', 
        'address' => 'required|string|max:255',
        'industry' => 'required|string|max:255',
        'website' => 'nullable|url|max:255',
        
         'owner_name' => 'required|string|max:255',
        'owner_email' => 'required|email|unique:users,email|max:255',
        'owner_password' => 'required|string|min:8|max:255',
    ];
}
     
     
     public function messages(): array
     {
        return [
            'name.required' => 'The company name is required.',
            'name.string' => 'The company name must be a string.',
            'name.max' => 'The company name may not be greater than 255 characters.',
            'address.required' => 'The company address is required.',
            'address.string' => 'The company address must be a string.',
            'address.max' => 'The company address may not be greater than 255 characters.',
            'industry.required' => 'The company industry is required.',
            'industry.string' => 'The company industry must be a string.',
            'industry.max' => 'The company industry may not be greater than 255 characters.',
            'website.url' => 'The company website must be a valid URL.',
            'website.max' => 'The company website may not be greater than 255 characters.',
            'website.string' => 'The company website must be a string.',
        ];
    }
}
