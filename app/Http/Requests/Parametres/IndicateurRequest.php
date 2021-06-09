<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class IndicateurRequest extends FormRequest
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
                                'unique:indicateurs,indicateur_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'champ_ar' => ['required',
                                'unique:indicateurs,indicateur_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"]
            ];
        }

        else{
            $rules = [
            'champ_fr' => ['required',
                            'unique:indicateurs,indicateur_fr,' . $this->indicateur['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'unique:indicateurs,indicateur_ar,'. $this->indicateur['id'],
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
            'champ_fr.required' => __('indicateurs.indicateur_fr required'),
            'champ_fr.max' => __('indicateurs.indicateur_fr max'),
            'champ_fr.unique' => __('indicateurs.indicateur_fr unique'),

            'champ_ar.required' => __('indicateurs.indicateur_ar required'),
            'champ_ar.max' => __('indicateurs.indicateur_ar max'),
            'champ_ar.unique' => __('indicateurs.indicateur_ar unique'),
            ////////////////////////////////////////////////
            'champ_fr.not_regex' => __('formone.regex_fr'),
            'champ_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
