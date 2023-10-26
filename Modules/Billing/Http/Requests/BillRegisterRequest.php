<?php

namespace Modules\Billing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Billing\Entities\BillRegister;
use Illuminate\Validation\ValidationException;

class BillRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function prepareForValidation()
    {
            $data = BillRegister::where('bill_no', $this->input('bill_no'))->select('bill_no')->get();
            if (count($data)) {
                throw ValidationException::withMessages(['bill_no' => 'The bill no' . $data . 'already been taken .'])
                    ->redirectTo($this->getRedirectUrl());
            }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
//            'amount.*' => 'required'
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
            'supplier_id.required' => 'Supplier is required',
            'amount.required' => 'Amount is required',
            'date.required' => 'Bill Date is required',
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
