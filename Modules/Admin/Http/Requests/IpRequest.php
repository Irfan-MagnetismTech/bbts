<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => ['required', Rule::unique('ips')->ignore($this->ip, 'address')],
            'type' => 'required',
            'purpose' => 'nullable',
            'vlan_id' => 'nullable',
            'zone_id' => 'nullable',
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
            'address.required' => 'IP Address is required',
            'address.unique' => 'IP Address already exists',
            'type.required' => 'IP Type is required',
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
