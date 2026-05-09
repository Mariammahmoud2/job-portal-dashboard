<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // تأكدي إنها true
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'salary'      => 'required|numeric',
            'type'        => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:job_categories,id',
            'company_id'  => 'required|exists:companies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'location.required' => 'The job location is required.',
            'salary.required' => 'The salary is required.',
            'type.required' => 'The job type is required.',
            'description.required' => 'The job description is required.',
            'category_id.required' => 'The job category is required.',
            'category_id.exists' => 'The selected job category is invalid.',
            'company_id.required' => 'The company is required.',
            'company_id.exists' => 'The selected company is invalid.',
            
        ];
    }
}