<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacancyupdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // لازم تكون true عشان يشتغل
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
            'title.required' => 'Please provide a job title.',
            'location.required' => 'Please provide a job location.',
            'salary.required' => 'Please provide a salary for the job.',
            'salary.numeric' => 'The salary must be a valid number.',
            'type.required' => 'Please specify the job type.',
            'description.required' => 'Please provide a job description.',
            'category_id.required' => 'Please select a job category.',
            'category_id.exists' => 'The selected job category is invalid.',
            'company_id.required' => 'Please select a company.',
            'company_id.exists' => 'The selected company is invalid.',
                    
         ];
    }
}