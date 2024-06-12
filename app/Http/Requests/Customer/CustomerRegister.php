<?php

namespace App\Http\Requests\Customer;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRegister extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
            'confirm_password' => ['required','same:password'],
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => __('error.This field is required'),
            'first_name.string' => __('error.The field must be a string'),
            'first_name.max' => __('error.The field must not exceed :max characters.'),
            'last_name.required' => __('error.This field is required'),
            'last_name.string' => __('error.The field must be a string'),
            'last_name.max' => __('error.The field must not exceed :max characters.'),
            'email.required' => __('error.This field is required'),
            'email.string' => __('error.The field must be a string'),
            'email.lowercase' => __('error.The email must be in lowercase letters.'),
            'email.email' => __('error.Please enter a valid email address.'),
            'email.max' =>  __('error.The field must not exceed :max characters.'),
            'email.unique' => __('error.The email address is already in use.'),
            'phone.required' => __('error.This field is required'),
            'phone.numeric' => __('error.Please enter a valid phone number.'),
            'phone.max' =>  __('error.The field must not exceed :max characters.'),
        ];
    }
}
