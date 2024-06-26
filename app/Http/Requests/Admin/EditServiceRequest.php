<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'service_name_en' => ['required', 'string'],
            'service_name_ar' => ['required', 'string'],
            'service_name_ur' => ['required', 'string'],
            'service_name_tr' => ['required', 'string'],
            // 'service_image' => ['required','file','mimes:jpeg,png,jpg'],

        ];
    }
    public function messages(): array
    {
        return [
            'service_name_en.required' => __('error.The Service Name English field is required'),
            'service_name_en.string' => __('error.The Service Name English field must be a string'),
            'service_name_ar.required' => __('error.The Service Name Arabic field is required'),
            'service_name_ar.string' => __('error.The Service Name Arabic field must be a string'),
            'service_name_ur.required' => __('error.The Service Name Urdu field is required'),
            'service_name_ur.string' => __('error.The Service Name Urdu field must be a string'),
            'service_name_tr.required' => __('error.The Service Name Turkish field is required'),
            'service_name_tr.string' => __('error.The Service Name Turkish field must be a string'),
            // 'service_image.required' => __('error.The Banner image field is required.'),
            // 'service_image.file' => __('error.The Banner image must be a file.'),
            // 'service_image.mimes' => __('error.The Banner image must be a file of type: jpeg, png, jpg.'),
        ];
    }
}
