<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScmChallanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date'               => 'required',
            'scm_requisition_id' => 'required',
            'purpose'            => 'required',
            'branch_id'          => 'required',
            'type'               => 'required',
            'equipment_type'     => 'required',
            'pop_id'             => 'required_if:type,pop',
            'client_no'          => 'required_if:type,client',
            'fr_no'              => 'required_if:type,client',
            'link_no'            => 'required_if:type,client,equipment_type,Link',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array
     */
    public function messages()
    {
        return [];
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
