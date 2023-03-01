<?php

namespace Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'visit_date' => 'required',
            'sales_representative' => 'required',
            'meeting_start_time' => 'required',
            'meeting_end_time' => 'required',
            'client_id' => 'required',
            'purpose' => 'required',
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
            'visit_date.required' => 'Visit date is required',
            'sales_representative.required' => 'Sales representative is required',
            'meeting_start_time.required' => 'Meeting start time is required',
            'meeting_end_time.required' => 'Meeting end time is required',
            'client_id.required' => 'Client is required',
            'purpose.required' => 'Purpose is required',
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
