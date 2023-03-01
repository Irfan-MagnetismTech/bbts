<?php

namespace Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'client_id' => 'required',
            // 'work_nature_type' => 'required',
            // 'call_type' => 'required',
            // 'visit_date' => 'required',
            // 'meeting_start_time' => 'required',
            // 'meeting_end_time' => 'required',
            // 'meeting_place' => 'required',
            // 'purpose' => 'required',
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
            // 'client_id.required' => 'Client is required',
            // 'work_nature_type.required' => 'Work nature type is required',
            // 'call_type.required' => 'Call type is required',
            // 'visit_date.required' => 'Visit date is required',
            // 'meeting_start_time.required' => 'Meeting start time is required',
            // 'meeting_end_time.required' => 'Meeting end time is required',
            // 'meeting_place.required' => 'Meeting place is required',
            // 'purpose.required' => 'Purpose is required',
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
