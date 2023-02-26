<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IndentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'indent_no' => ['required', 'string', 'max:255', Rule::unique('indents')->ignore($this->indent, 'indent_no')],
            'date' => 'required',
            'prs_no' => 'required',
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
            'indent_no.required' => 'Indent No is required',
            'indent_no.unique' => 'Indent No already exists',
            'date.required' => 'Date is required',
            'prs_no.required' => 'Purchase Requisition No is required',
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
