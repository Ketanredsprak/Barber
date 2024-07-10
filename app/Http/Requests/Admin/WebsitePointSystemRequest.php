<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebsitePointSystemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'per_booking_points' => ['required','numeric'],
            'per_active_referral_points' => ['required','numeric'],
            'how_many_point_equal_sr' => ['required','numeric'],
        ];
    }
    public function messages(): array
    {
        return [
            'per_booking_points.required' => __('error.This field is required'),
            'per_active_referral_points.required' => __('error.This field is required'),
            'how_many_point_equal_sr.required' => __('error.This field is required'),
            'per_booking_points.numeric' => __('error.The field must be a numeric'),
            'per_active_referral_points.numeric' => __('error.The field must be a numeric'),
            'how_many_point_equal_sr.numeric' => __('error.The field must be a numeric'),
        ];
    }
}
