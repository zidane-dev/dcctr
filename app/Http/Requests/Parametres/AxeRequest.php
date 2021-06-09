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
            'axe_fr.required' => __('axes.axe_fr required'),
            'axe_fr.max' => __('axes.axe_fr max'),
            'axe_fr.unique' => __('axes.axe_fr unique'),

            'axe_ar.required' => __('axes.axe_ar required'),
            'axe_ar.max' => __('axes.axe_ar max'),
            'axe_ar.unique' => __('axes.axe_ar unique'),
            ////////////////////////////////////////////////
            'axe_fr.not_regex' => __('formone.regex_fr'),
            'axe_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
