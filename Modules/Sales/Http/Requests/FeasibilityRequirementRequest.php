<?php

namespace Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeasibilityRequirementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_no' => 'required',
            'is_existing' => 'required',
            // 'connectivity_point' => 'required|unique:feasibility_requirement_details,connectivity_point,' . $this->id,
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'client_no.required' => 'The client name field is required.',
            'is_existing.required' => 'The is existing field is required.',
            'connectivity_point.required' => 'The connectivity point field is required.',
            'connectivity_point.unique' => 'The connectivity point has already been taken.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
