<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Validation\ValidationException;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\ScmMrrSerialCodeLine;

class ScmReportRequest extends FormRequest
{
    /**
     * Manupulate the request data before validation
     * @return void
     *
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch_id' => 'required',
            'material_id' => 'required',
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
            'branch_id.required' => 'Branch is Required',
            'material_id.required' => 'Material is Required',
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
