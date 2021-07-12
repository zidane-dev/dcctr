<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UploadRequest extends FormRequest
{    
    public function authorize()
    {
        if(Auth::user()->hasPermissionTo('dc'))
            return true;
        return false;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:doc,docx,xlsx,pdf|max:5550000',
            'champ_fr' => ['required',
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'min:3',
                            "regex:/\p{Arabic}/u"],
        ];
    }
    public function messages()
    {
        return [
            'file.required' => __('uploads.required'),
            'file.max' => __('uploads.max'),
            'file.mimes' => __('uploads.extension')._('uploads.mimes'),
            'champ_fr.not_regex' => __('formone.regex_fr'),
            'champ_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
