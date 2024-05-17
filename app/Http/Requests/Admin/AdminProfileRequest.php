<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'numeric'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => __('error.This field is required'),
            'name.string' => __('error.The field must be a string'),
            'name.max' => __('error.The field must not exceed :max characters.'),
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
