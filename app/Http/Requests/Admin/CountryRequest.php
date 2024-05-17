<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //
            'country_name_en' => ['required', 'string', 'max:255'],
            'country_name_ar' => ['required', 'string', 'max:255'],
            'country_name_ur' => ['required', 'string', 'max:255'],
            'country_short_name' => ['required','string'],
            'country_phone_code' => ['required','numeric'],
        ];
    }
    public function messages(): array
    {
        return [
            'country_name_en.required' => __('error.This field is required'),
            'country_name_en.string' => __('error.The field must be a string'),
            'country_name_en.max' => __('error.The field must not exceed :max characters.'),
            'country_name_ar.required' => __('error.This field is required'),
            'country_name_ar.string' => __('error.The field must be a string'),
            'country_name_ar.max' => __('error.The field must not exceed :max characters.'),
            'country_name_ur.required' => __('error.This field is required'),
            'country_name_ur.string' => __('error.The field must be a string'),
            'country_name_ur.max' => __('error.The field must not exceed :max characters.'),
            'country_short_name.required' => __('error.This field is required'),
            'country_short_name.string' => __('error.The field must be a string'),
            'country_phone_code.required' => __('error.This field is required'),
            'country_phone_code.numeric' => __('error.The field must be a numeric'),

        ];
    }
}
