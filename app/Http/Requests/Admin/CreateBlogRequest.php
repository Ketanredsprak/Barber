<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
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
            'blog_image' => ['required','file','mimes:jpeg,png,jpg'],
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
            'blog_image.required' => __('error.The Blog image field is required.'),
            'blog_image.file' => __('error.The Blog image must be a file.'),
            'blog_image.mimes' => __('error.The Blog image must be a file of type: jpeg, png, jpg.'),
        ];
    }
}
