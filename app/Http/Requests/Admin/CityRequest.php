<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'city_name_en' => ['required', 'string', 'max:255'],
            'city_name_ar' => ['required', 'string', 'max:255'],
            'city_name_ur' => ['required', 'string', 'max:255'],
            'country_id' => ['required'],
            'state_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'city_name_en.required' => __('error.This field is required'),
            'city_name_en.string' => __('error.The field must be a string'),
            'city_name_en.max' => __('error.The field must not exceed :max characters.'),
            'city_name_ar.required' => __('error.This field is required'),
            'city_name_ar.string' => __('error.The field must be a string'),
            'city_name_ar.max' => __('error.The field must not exceed :max characters.'),
            'city_name_ur.required' => __('error.This field is required'),
            'city_name_ur.string' => __('error.The field must be a string'),
            'city_name_ur.max' => __('error.The field must not exceed :max characters.'),
            'country_id.required' => __('error.This field is required'),
            'state_id.required' => __('error.This field is required'),
        ];
    }
}
