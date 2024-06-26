<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'title_en' => ['required','string'],
            'title_ar' => ['required','string'],
            'title_ur' => ['required','string'],
            'title_tr' => ['required','string'],
            'content_en' => ['required','string'],
            'content_ar' => ['required','string'],
            'content_ur' => ['required','string'],
            'content_tr' => ['required','string'],
            'banner_image' => ['required','file','mimes:jpeg,png,jpg'],
            'barber_id' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'title_en.required' => __('error.The Title English field is required'),
            'title_en.string' => __('error.The Title English field must be a string'),
            'title_ar.required' => __('error.The Title Arabic field is required'),
            'title_ar.string' => __('error.The Title Arabic field must be a string'),
            'title_ur.required' => __('error.The Title Urdu field is required'),
            'title_ur.string' => __('error.The Title Urdu field must be a string'),
            'title_tr.required' => __('error.The Title Turkish field is required'),
            'title_tr.string' => __('error.The Title Turkish field must be a string'),
            'content_en.required' => __('error.The Content English field is required'),
            'content_en.string' => __('error.The Content English field must be a string'),
            'content_ar.required' => __('error.The Content Arabic field is required'),
            'content_ar.string' => __('error.The Content Arabic field must be a string'),
            'content_ur.required' => __('error.The Content Urdu field is required'),
            'content_ur.string' => __('error.The Content Urdu field must be a string'),
            'content_tr.required' => __('error.The Content Turkish field is required'),
            'content_tr.string' => __('error.The Content Turkish field must be a string'),
            'barber_id.required' => __('error.Select Barber field is required'),
            'banner_image.required' => __('error.The Banner image field is required.'),
            'banner_image.file' => __('error.The Banner image must be a file.'),
            'banner_image.mimes' => __('error.The Banner image must be a file of type: jpeg, png, jpg.'),
        ];
    }
}
