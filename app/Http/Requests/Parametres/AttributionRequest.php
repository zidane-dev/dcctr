<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class AttributionRequest extends FormRequest
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
                'attribution_fr' => ['required',
                                'unique:attributions,attribution_fr',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                'attribution_ar' => ['required',
                                'unique:attributions,attribution_ar',
                                'max:250',
                                'min:3',
                                "regex:/\p{Arabic}/u"],
                'secteur_id'    => 'required',
            ];
        }

        else{
            $rules = [
            'attribution_fr' => ['required',
                            'unique:attributions,attribution_fr,' . $this->attribution['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            'attribution_ar' => ['required',
                            'unique:attributions,attribution_ar,'. $this->attribution['id'],
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
            'attribution_fr.required' => __('attributions.attribution_fr required'),
            'attribution_fr.max' => __('attributions.attribution_fr max'),
            'attribution_fr.unique' => __('attributions.attribution_fr unique'),

            'attribution_ar.required' => __('attributions.attribution_ar required'),
            'attribution_ar.max' => __('attributions.attribution_ar max'),
            'attribution_ar.unique' => __('attributions.attribution_ar unique'),

            'secteur.required' => __('objectifs.secteur required'),
            ////////////////////////////////////////////////
            'attribution_fr.not_regex' => __('formone.regex_fr'),
            'attribution_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
