<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCountryCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:255'],
            'phonecode' => ['required','numeric'],
            'image' =>  ['required','file','mimes:jpeg,png,jpg'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => __('error.This field is required'),
            'name.string' => __('error.The field must be a string'),
            'name.max' => __('error.The field must not exceed :max characters.'),
            'short_name.required' => __('error.This field is required'),
            'short_name.string' => __('error.The field must be a string'),
            'short_name.max' => __('error.The field must not exceed :max characters.'),
            'phonecode.required' => __('error.This field is required'),
            'phonecode.numeric' => __('error.The field must be a numeric'),
            'image.required' => __('error.The Banner image field is required.'),
            'image.file' => __('error.The Banner image must be a file.'),
            'image.mimes' => __('error.The Banner image must be a file of type: jpeg, png, jpg.'),

        ];
    }
}
