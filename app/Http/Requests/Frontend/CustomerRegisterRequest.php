<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'first_name' => ['required','max:10'],
            'last_name' => ['required','max:10'],
            'phone' => ['required','numeric','digits_between:8,12','unique:users,phone'],
            'email' => ['required','string', 'lowercase', 'email', 'max:255','unique:users,email'],
            'gender' => ['required'],
            'password' => ['required'],
            'terms_and_conditions' => ['required'],
            'confirm_password' => ['same:password','required'],

        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => __('error.The first name field is required.'),
            'first_name.max' => __('error.The first name must be at least 4 characters.'),
            'last_name.required' => __('error.The last name field is required.'),
            'last_name.max' => __('error.The last name must be at least 4 characters.'),
            'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.string' => __('error.The field must be a string'),
            'email.unique' => __('error.The email has already been taken.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'phone.required' => __('error.This field is required'),
            'phone.numeric' => __('error.Please enter a valid phone number.'),
            'phone.unique' => __('error.The phone number has already been taken.'),
            'phone.digits_between' =>  __('error.The phone number must be between 8 and 12 digits.'),
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),
            'terms_and_conditions.required' => __('error.The terms and conditions field is required.'),

        ];
    }
}
