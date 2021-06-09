<?php

namespace App\Http\Requests\Parametres;

use Illuminate\Foundation\Http\FormRequest;

class StructureRequest extends FormRequest
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
                'structure_fr' => ['required',
                                'unique:structures,structure',
                                'max:250',  
                                'min:3',
                                "not_regex:/\p{Arabic}/u"],
                // 'structure_ar' => ['required',
                //                 'unique:structures,structure_ar',
                //                 'max:250',
                //                 'min:3',
                //                 "regex:/\p{Arabic}/u"]
            ];
        }

        else{
            $rules = [
            'structure_fr' => ['required',
                            'unique:structures,structure,' . $this->structure['id'],
                            'max:250',  
                            'min:3',
                            "not_regex:/\p{Arabic}/u"],
            // 'structure_ar' => ['required',
            //                 'unique:structures,structure_ar,'. $this->structure['id'],
            //                 'max:250',
            //                 'min:3',
            //                 "regex:/\p{Arabic}/u"]
            ];
        }      

        return $rules;;
    }
    public function messages()
    {
        return [
            'structure_fr.required' => __('structures.structure_fr required'),
            'structure_fr.max' => __('structures.structure_fr max'),
            'structure_fr.unique' => __('structures.structure_fr unique'),

            'structure_ar.required' => __('structures.structure_ar required'),
            'structure_ar.max' => __('structures.structure_ar max'),
            'structure_ar.unique' => __('structures.structure_ar unique'),
/////////////////////////////////////////////////////////////
            'structure_fr.not_regex' => __('formone.regex_fr'),
            'structure_ar.regex' => __('formone.regex_ar'),
        ];
    }
}
