<?php

namespace Modules\Networking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:data_types,name'
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
            'name.required' => 'Data Type Name is required',
            'name.unique' => 'Data Type Name is already exists'
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
