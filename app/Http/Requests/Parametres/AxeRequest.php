<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class AxeRequest extends FormRequest
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
                                'unique:axes,axe_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'champ_ar' => ['required',
                                'unique:axes,axe_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"]
            ];
        }

        else{
            $rules = [
            'champ_fr' => ['required',
                            'unique:axes,axe_fr,' . $this->axe['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'champ_ar' => ['required',
                            'unique:axes,axe_ar,'. $this->axe['id'],
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
            'champ_fr.required' => __('axes.fr required'),
            'champ_fr.max'      => __('axes.fr max'),
            'champ_fr.unique'   => __('axes.fr unique'),

            'champ_ar.required' => __('axes.ar required'),
            'champ_ar.max'      => __('axes.ar max'),
            'champ_ar.unique'   => __('axes.ar unique'),
            ////////////////////////////////////////////////
            'champ_fr.not_regex' => __('formone.regex_fr'),
            'champ_ar.regex'     => __('formone.regex_ar'),
        ];
    }
}
