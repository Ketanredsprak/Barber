<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditTestimonialRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'name_ur' => ['required'],
            'name_tr' => ['required'],
            'designation_en' => ['required'],
            'designation_ar' => ['required'],
            'designation_ur' => ['required'],
            'designation_tr' => ['required'],
            'testimonial_content_en' => ['required'],
            'testimonial_content_ar' => ['required'],
            'testimonial_content_ur' => ['required'],
            'testimonial_content_tr' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'name_en.required' => __('error.This Name Enlish field is required'),
            'name_ar.required' => __('error.This Name Arabic field is required'),
            'name_ur.required' => __('error.This Name Urdu field is required'),
            'name_tr.required' => __('error.This Name Turkish field is required'),
            'designation_en.required' => __('error.This Designation Enlish field is required'),
            'designation_ar.required' => __('error.This Designation Arabic field is required'),
            'designation_ur.required' => __('error.This Designation Urdu field is required'),
            'designation_tr.required' => __('error.This Designation Turkish field is required'),
            'testimonial_content_en.required' => __('error.This Testimonial Content Enlish field is required'),
            'testimonial_content_ar.required' => __('error.This Testimonial Content Arabic field is required'),
            'testimonial_content_ur.required' => __('error.This Testimonial Content Urdu field is required'),
            'testimonial_content_tr.required' => __('error.This Testimonial Content Turkish field is required'),
        ];
    }
}
