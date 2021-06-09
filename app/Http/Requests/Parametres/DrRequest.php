<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class DrRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
            if($this->getMethod() == 'POST'){
                $rules = [
                    'region_fr' => ['required',
                                    'unique:drs,region_fr',
                                    'max:250',  
                                    'min:3',
                                    "not_regex:/\p{Arabic}/u"],
                    'region_ar' => ['required',
                                    'unique:drs,region_ar',
                                    'max:250',
                                    'min:3',
                                    "regex:/\p{Arabic}/u"]
                ];
            }
            else{
                $rules = [
                'region_fr' => ['required',
                                'unique:drs,region_fr,'. $this->region['id'],
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'region_ar' => ['required',
                                'unique:drs,region_ar,'. $this->region['id'],
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"]
                ];
            }     
            return $rules;
    }

    public function messages()
    {
        return [
            'region_fr.required' => __('drs.region_fr required'),
            'region_fr.max' => __('drs.region_fr max'),
            'region_fr.unique' => __('drs.region_fr unique'),

            'region_ar.required' => __('drs.region_ar required'),
            'region_ar.max' => __('drs.region_ar max'),
            'region_ar.unique' => __('drs.region_ar unique'),

            'region_fr.not_regex' => __('formone.regex_fr'),
            'region_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
