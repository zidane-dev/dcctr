<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class UniteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->getMethod() == 'POST'){
            $rules = [
                'champ_fr' => ['required',
                                'unique:unites,unite_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'champ_ar' => ['required',
                                'unique:unites,unite_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"]
            ];
        }

        else{
            $rules = [
            'champ_fr' => ['required',
                            'unique:unites,unite_fr,' . $this->unite['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'unique:unites,unite_ar,'. $this->unite['id'],
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
            'unite_fr.required' => __('unites.unite_fr required'),
            'unite_fr.max' => __('unites.unite_fr max'),
            'unite_fr.unique' => __('unites.unite_fr unique'),

            'unite_ar.required' => __('unites.unite_ar required'),
            'unite_ar.max' => __('unites.unite_ar max'),
            'unite_ar.unique' => __('unites.unite_ar unique'),
            ////////////////////////////////////////////////
            'unite_fr.not_regex' => __('unites.unite_fr regex'),
            'unite_ar.regex' => __('unites.unite_ar regex'),
        ];
    }
}
