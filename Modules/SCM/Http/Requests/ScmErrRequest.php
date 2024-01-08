<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScmErrRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'                   => 'required',
            'date'                   => 'required',
            'purpose'                => 'required',
            'branch_id'              => 'required',
            'assigned_person'        => 'required',
            'reason_of_inactive'     => 'required',
            'inactive_date'          => 'required',
            'pop_id'                 => 'required_if:type,internal',
            'equipment_type'         => 'required_if:type,client',
            'client_name'            => 'required_if:type,client',
            'fr_no'                  => 'required_if:type,client',
            'client_no'              => 'required_if:type,client',
            'link_no'                => 'required_if:type,client,equipment_type,Link',
            'material_id'            => 'array',
            'material_id.*'          => 'required',
            'brand_id'               => 'array',
            'brand_id.*'             => 'required',
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
            //
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
