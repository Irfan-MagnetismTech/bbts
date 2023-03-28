<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScmMirRequest extends FormRequest
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
            'branch_id' => 'required',
            'to_branch_id' => 'required',
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
            'date.required' => 'Date is required',
            'branch_id.required' => 'From Branch is required',
            'to_branch_id.required' => 'To Branch is required',
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
