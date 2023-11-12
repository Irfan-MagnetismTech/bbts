<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScmPurchaseRequisitionRequest extends FormRequest
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
            'client_no' => 'required_if:type,client',
            // 'fr_no' => 'required:type,client',
            'link_no' => 'required_if:type,link',
            // 'material_id.*' => 'required',
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
            'client_no.required_if' => 'Client is required',
            'fr_no.required_if' => 'FR is required',
            'link_no.required_if' => 'Link is required',
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
