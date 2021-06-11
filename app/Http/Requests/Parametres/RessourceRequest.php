<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class RessourceRequest extends FormRequest
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

    public function rules()
    {
        if($this->getMethod() == 'POST'){
            $rules = [
                'champ_fr' => ['required',
                                'unique:ressources,ressource_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'champ_ar' => ['required',
                                'unique:ressources,ressource_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"]
            ];
        }

        else{
            $rules = [
            'champ_fr' => ['required',
                            'unique:ressources,ressource_fr,' . $this->ressource['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'unique:ressources,ressource_ar,'. $this->ressource['id'],
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
            'champ_fr.required' => __('ressources._fr required'),
            'champ_fr.max' => __('ressources._fr max'),
            'champ_fr.min' => __('ressources._fr min'),
            'champ_fr.unique' => __('ressources._fr unique'),

            'champ_ar.required' => __('ressources._ar required'),
            'champ_ar.max' => __('ressources._ar max'),
            'champ_ar.min' => __('ressources._ar min'),
            'champ_ar.unique' => __('ressources._ar unique'),
            ////////////////////////////////////////////////
            'champ_fr.not_regex' => __('formone.regex_fr'),
            'champ_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
