<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'subscription_name_en' => ['required'],
            'subscription_name_ar' => ['required'],
            'subscription_name_ur' => ['required'],
            'subscription_name_tr' => ['required'],
            'subscription_description_en' => ['required'],
            'subscription_description_ar' => ['required'],
            'subscription_description_ur' => ['required'],
            'subscription_description_tr' => ['required'],
            'price' => ['required','numeric'],
            'duration_in_days' => ['required','numeric'],
            'number_of_booking' => ['required','numeric'],
            // 'subscription_type' => ['required'],
            ];
    }
    public function messages(): array
    {
        return [
            'subscription_name_en.required' => __('error.The Subscription Name English field is required'),
            'subscription_name_ar.required' => __('error.The Subscription Name Arabic field is required'),
            'subscription_name_ur.required' => __('error.The Subscription Name Urdu field is required'),
            'subscription_name_tr.required' => __('error.The Subscription Name Turkish field is required'),
            'subscription_description_en.required' => __('error.The Subscription Description English field is required'),
            'subscription_description_ar.required' => __('error.The Subscription Description Arabic field is required'),
            'subscription_description_ur.required' => __('error.The Subscription Description Urdu field is required'),
            'subscription_description_tr.required' => __('error.The Subscription Description Turkish field is required'),
            'price.required' => __('error.The Price field is required'),
            'price.numeric' => __('error.The Price field must be a numeric'),
            'duration_in_days.required' => __('error.The Duration field is required'),
            'duration_in_days.numeric' => __('error.The Duration field must be a numeric'),
            'number_of_booking.required' => __('error.The Number of Booking field is required'),
            'number_of_booking.numeric' => __('error.The Number of Booking field must be a numeric'),
            'subscription_type.required' => __('error.The Subscription Type field is required'),
        ];
    }
}
