<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class QualiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->getMethod() == 'POST'){
            $rules = [
                'champ_fr' => ['required',
                                'unique:qualites,qualite_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'champ_ar' => ['required',
                                'unique:qualites,qualite_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"]
            ];
        }

        else{
            $rules = [
            'champ_fr' => ['required',
                            'unique:qualites,qualite_fr,' . $this->qualite['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'unique:qualites,qualite_ar,'. $this->qualite['id'],
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
            'champ_fr.required' => __('qualites.qualite_fr required'),
            'champ_fr.max' => __('qualites.qualite_fr max'),
            'champ_fr.unique' => __('qualites.qualite_fr unique'),

            'champ_ar.required' => __('qualites.qualite_ar required'),
            'champ_ar.max' => __('qualites.qualite_ar max'),
            'champ_ar.unique' => __('qualites.qualite_ar unique'),
            ////////////////////////////////////////////////
            'champ_fr.not_regex' => __('formone.regex_fr'),
            'champ_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
