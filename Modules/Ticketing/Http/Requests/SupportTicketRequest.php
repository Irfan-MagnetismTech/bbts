<?php

namespace Modules\Ticketing\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SupportTicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fr_no' => 'required',
            'complain_time' => 'date',
            'description' => 'string',
            'priority' => [
                'string',
                Rule::in(config('businessinfo.ticketPriorities')),
            ],
            'remarks' => 'string',
            'sources_id' => 'integer|exists:ticket_sources,id',
            'complain_types_id' => 'integer|exists:support_complain_types,id',
            'status' => [
                'string',
                Rule::in(config('businessinfo.ticketStatuses')),
            ],

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
            //
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
