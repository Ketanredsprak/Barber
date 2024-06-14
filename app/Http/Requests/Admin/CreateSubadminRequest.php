<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubadminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //
            'first_name' => ['required','min:4',],
            'last_name' => ['required','min:4',],
            'phone' => ['required','unique:users','min:9','max:11'],
            'email' => ['required','email','unique:users','email'],
            'gender' => ['required'],
            'profile_image' => ['required','file','mimes:jpeg,png,jpg'],
            'password' => ['required'],
            'confirm_password' => ['same:password','required'],
        ];
    }
    public function messages(): array
    {


        return [
            'first_name.required' => __('error.The first name field is required.'),
            'first_name.min' => __('error.The first name must be at least 4 characters.'),
            'last_name.required' => __('error.The last name field is required.'),
            'last_name.min' => __('error.The first name must be at least 4 characters.'),
            'phone.required' => __('error.The phone number field is required.'),
            'phone.min' => __('error.The phone number must be at least 9 characters.'),
            'phone.max' => __('error.The phone number may not be greater than 11 characters.'),
            'phone.unique' => __('error.The phone number has already been taken.'),
            'gender.required' => __('error.The gender field is required.'),
            'email.required' => __('error.The email field is required.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'email.unique' => __('error.The email has already been taken.'),
            'profile_image.required' => __('error.The profile image field is required.'),
            'profile_image.file' => __('error.The profile image must be a file.'),
            'profile_image.mimes' => __('error.The profile image must be a file of type: jpeg, png, jpg.'),
            'password.required' => __('error.The password field is required.'),
            'confirm_password.same' => __('error.The confirm password must match the password.'),
            'confirm_password.required' => __('error.The confirm password field is required.'),

        ];
    }
}
