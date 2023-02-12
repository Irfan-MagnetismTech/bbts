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
            'date' => 'required',
            // 'requisition_type' => 'required',
            // 'requisition_by' => 'required',
            // 'requisition_to' => 'required',
            // 'requisition_status' => 'required',
            // 'requisition_remarks' => 'required',
            // 'requisition_details' => 'required',
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
            'date.required' => 'Requisition Date is required',
            // 'requisition_type.required' => 'Requisition Type is required',
            // 'requisition_by.required' => 'Requisition By is required',
            // 'requisition_to.required' => 'Requisition To is required',
            // 'requisition_status.required' => 'Requisition Status is required',
            // 'requisition_remarks.required' => 'Requisition Remarks is required',
            // 'requisition_details.required' => 'Requisition Details is required'
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
