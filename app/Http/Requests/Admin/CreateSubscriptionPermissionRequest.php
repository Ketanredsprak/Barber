<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionPermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'permission_name' => ['required'],
            'subscription_id' => ['required'],
            'permission_for_user' => ['required'],

        ];
    }
    public function messages(): array
    {
        return [
            'permission_name.required' => __('error.This field is required'),
            'subscription_id.required' => __('error.This field is required'),
            'permission_for_user.required' => __('error.This field is required'),

        ];
    }
}
