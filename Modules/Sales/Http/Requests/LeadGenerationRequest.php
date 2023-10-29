<?php

namespace Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadGenerationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name' => 'required',
            'address' => 'required',
            'contact_person' => 'required',
            'contact_no' => 'required',
            'email' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'thana_id' => 'required',
            'business_type' => 'required',
            'designation' => 'required',
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
            'client_name.required' => 'Client name is required',
            'address.required' => 'Address is required',
            'contact_person.required' => 'Contact person is required',
            'contact_no.required' => 'Contact number is required',
            'email.required' => 'Email is required',
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
