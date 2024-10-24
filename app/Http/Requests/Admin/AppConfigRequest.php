<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AppConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            // 'customer_app_login_image' => ['required'],
            // 'barber_app_login_image' => ['required'],
            'customer_app_title_en' => ['required'],
            'customer_app_title_ar' => ['required'],
            'customer_app_title_ur' => ['required'],
            'customer_app_title_tr' => ['required'],
            'customer_app_content_en' => ['required'],
            'customer_app_content_ar' => ['required'],
            'customer_app_content_ur' => ['required'],
            'customer_app_content_tr' => ['required'],
            'barber_app_title_en' => ['required'],
            'barber_app_title_ar' => ['required'],
            'barber_app_title_ur' => ['required'],
            'barber_app_title_tr' => ['required'],
            'barber_app_content_en' => ['required'],
            'barber_app_content_ar' => ['required'],
            'barber_app_content_ur' => ['required'],
            'barber_app_content_tr' => ['required'],

        ];
    }
    public function messages(): array
    {
        return [
            'customer_app_login_image.required' => __('error.This field is required'),
            'barber_app_login_image.required' => __('error.This field is required'),
            'customer_app_title_en' => __('error.This field is required'),
            'customer_app_title_ar' => __('error.This field is required'),
            'customer_app_title_ur' => __('error.This field is required'),
            'customer_app_title_tr' => __('error.This field is required'),
            'customer_app_content_en' => __('error.This field is required'),
            'customer_app_content_ar' => __('error.This field is required'),
            'customer_app_content_ur' => __('error.This field is required'),
            'customer_app_content_tr' => __('error.This field is required'),
            'barber_app_title_en' => __('error.This field is required'),
            'barber_app_title_ar' => __('error.This field is required'),
            'barber_app_title_ur' => __('error.This field is required'),
            'barber_app_title_tr' => __('error.This field is required'),
            'barber_app_content_en' => __('error.This field is required'),
            'barber_app_content_ar' => __('error.This field is required'),
            'barber_app_content_ur' => __('error.This field is required'),
            'barber_app_content_tr' => __('error.This field is required'),


        ];
    }
}
