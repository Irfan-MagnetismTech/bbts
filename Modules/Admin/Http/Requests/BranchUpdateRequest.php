<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $branche = $this->route('branch');
        //  dd($branche);
        return [
             'name' => "required|unique:branches,name, $branche->id",
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'thana_id' => 'required|exists:thanas,id',
            'location' => 'required'
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
            'name.unique' => 'Name already exists',
            'division_id.required' => 'Division is required',
            'district_id.required' => 'District is required',
            'thana_id.required' => 'Thana is required',
            'location.required' => 'Location is required',
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
