<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'name_en' => ['required', 'string'],
            'name_ar' => ['required', 'string'],
            'name_ur' => ['required', 'string'],
            'name_tr' => ['required', 'string'],

        ];
    }
    public function messages(): array
    {
        return [
            'name_en.required' => __('error.The Subject Name English field is required'),
            'name_en.string' => __('error.The Subject Name English field must be a string'),
            'name_ar.required' => __('error.The Subject Name Arabic field is required'),
            'name_ar.string' => __('error.The Subject Name Arabic field must be a string'),
            'name_ur.required' => __('error.The Subject Name Urdu field is required'),
            'name_ur.string' => __('error.The Subject Name Urdu field must be a string'),
            'name_tr.required' => __('error.The Subject Name Turkish field is required'),
            'name_tr.string' => __('error.The Subject Name Turkish field must be a string')
        ];
    }
}
