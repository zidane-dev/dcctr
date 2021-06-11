<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class DepenseRequest extends FormRequest
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
                                ':depenses,depense_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'champ_ar' => ['required',
                                'unique:depenses,depense_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"],
                'ressource'    => 'required',
            ];
        }

        else{
            $rules = [
            'champ_fr' => ['required',
                            'unique:depenses,depense_fr,' . $this->depense['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'unique:depenses,depense_ar,'. $this->depense['id'],
                            'max:250',
                            'min:3',
                            "regex:/\p{Arabic}/u"],
            'ressource'    => 'required',
            ];
        }      

        return $rules;
    }
    public function messages()
    {
        return [
            'champ_fr.required' => __('depenses.depense_fr required'),
            'champ_fr.max' => __('depenses.depense_fr max'),
            'champ_fr.min' => __('depenses.depense_fr min'),
            'champ_fr.unique' => __('depenses.depense_fr unique'),

            'champ_ar.required' => __('depenses.depense_ar required'),
            'champ_ar.max' => __('depenses.depense_ar max'),
            'champ_ar.min' => __('depenses.depense_ar min'),
            'champ_ar.unique' => __('depenses.depense_ar unique'),

            'ressource.required' => __('depenses.ressource required'),
            ////////////////////////////////////////////////
            'champ_fr.not_regex' => __('formone.regex_fr'),
            'champ_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
