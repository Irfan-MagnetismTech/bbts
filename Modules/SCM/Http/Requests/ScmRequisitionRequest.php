<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScmRequisitionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'date' => 'required|date',
            'branch_id' => 'required|integer|exists:branches,id',
            'client_no' => 'required_if:type,client',
            'fr_no' => 'required_if:type,client',
            'link_no' => 'required_if:type,client',
            'material_id.*' => 'sometimes',
            'brand_id.*' => 'required',
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
            'type.required' => 'Requisition Type is required',
            'date.required' => 'Requisition Date is required',
            'date.date' => 'Requisition Date is invalid',
            'branch_id.required' => 'Branch is required',
            'branch_id.integer' => 'Branch id must be integer',
            'branch_id.exists' => 'Branch is invalid',
            'fr_id.required_if' => 'Client FR ID is required',
            'fr_id.exists' => 'Client is invalid',
            'client_id.required_if' => 'Client is required',
            'material_id.*.required' => 'Material is required',
            'brand_id.*.required' => 'Brand is required',
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
