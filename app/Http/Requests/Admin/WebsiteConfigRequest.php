<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'location_en' => ['required'],
            'location_ar' => ['required'],
            'location_ur' => ['required'],
            'location_tr' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
            'facebook_link' => ['required'],
            'twitter_link' => ['required'],
            'linkedin_link' => ['required'],
            'youtube_link' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'location_en.required' => __('error.This field is required'),
            'location_ar.required' => __('error.This field is required'),
            'location_ur.required' => __('error.This field is required'),
            'location_tr.required' => __('error.This field is required'),
            'phone.required' => __('error.This field is required'),
            'email.required' => __('error.This field is required'),
            'facebook_link.required' => __('error.This field is required'),
            'twitter_link.required' => __('error.This field is required'),
            'linkedin_link.required' => __('error.This field is required'),
            'youtube_link.required' => __('error.This field is required'),

        ];
    }
}