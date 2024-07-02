<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactSubmitRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'first_name' => ['required'],
            'last_name' => ['required'],
            'note' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'subject' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => __('error.This field is required'),
            'last_name.required' => __('error.This field is required'),
            'note.required' => __('error.This field is required'),
            'subject.required' => __('error.This field is required'),
            'email.required' => __('error.This field is required'),
            'email.string' => __('error.The field must be a string'),
            'email.email' => __('error.Please enter a valid email address.'),
            'email.max' =>  __('error.The field must not exceed :max characters.'),

        ];
    }
}
