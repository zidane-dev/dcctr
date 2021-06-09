<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class ObjectifRequest extends FormRequest
{
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
                'objectif_fr' => ['required',
                                'unique:objectifs,objectif_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'objectif_ar' => ['required',
                                'unique:objectifs,objectif_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"],
                'secteur_id'    => 'required',
            ];
        }

        else{
            $rules = [
            'objectif_fr' => ['required',
                            'unique:objectifs,objectif_fr,' . $this->objectif['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'objectif_ar' => ['required',
                            'unique:objectifs,objectif_ar,'. $this->objectif['id'],
                            'max:250',
                            'min:3',
                            "regex:/\p{Arabic}/u"],
            'secteur_id'    => 'required',
            ];
        }      

        return $rules;
    }
    public function messages()
    {
        return [
            'objectif_fr.required' => __('objectifs.objectif_fr required'),
            'objectif_fr.max' => __('objectifs.objectif_fr max'),
            'objectif_fr.unique' => __('objectifs.objectif_fr unique'),

            'objectif_ar.required' => __('objectifs.objectif_ar required'),
            'objectif_ar.max' => __('objectifs.objectif_ar max'),
            'objectif_ar.unique' => __('objectifs.objectif_ar unique'),

            'secteur.required' => __('objectifs.secteur required'),
            ////////////////////////////////////////////////
            'objectif_fr.not_regex' => __('formone.regex_fr'),
            'objectif_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
