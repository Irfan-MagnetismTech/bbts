<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'designation_id' => 'required|exists:designations,id',
            'department_id' => 'required|exists:departments,id',
            'nid' => 'required|regex:/^[0-9]/',
            'blood_group' => 'required|string',
            'father' => 'required|string',
            'mother' => 'required|string',
            'joining_date' => 'required|date',
            'job_experience' => 'required',
            'emergency' => 'required|string',
            'job_experience' => 'required',
            'dob' => 'required|date',
            'contact' => 'required|string',
            'email' => 'required|email',
            'pre_street_address' => 'required',
            'pre_division_id' =>'required|exists:divisions,id',
            'pre_district_id' =>'required|exists:districts,id',
            'pre_thana_id' => 'required|exists:thanas,id',
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
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists'
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
