<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cs_no'                   => ['required', 'string', 'max:255', Rule::unique('cs')->ignore($this->c, 'cs_no')], //$this->c is the id of the cs
            'effective_date'          => ['required', 'date', 'date_format:d-m-Y'],
            'expiry_date'             => ['required', 'date', 'date_format:d-m-Y', 'after:effective_date'],
            'remarks'                 => ['present', 'nullable', 'string'],

            'material_id'             => ['required', 'array'],
            'material_id.*'           => ['required', 'exists:materials,id', 'distinct'],
            'material_name'           => ['required', 'array'],
            'material_name.*'         => ['required', 'string'],

            'supplier_id'             => ['required', 'array'],
            'supplier_id.*'           => ['required', 'exists:suppliers,id', 'distinct'],
            'supplier_name'           => ['required', 'array'],
            'supplier_name.*'         => ['required', 'string'],
            'checked_supplier'        => ['required', 'array'],
            'quotation_no'            => ['required', 'array'],
            'vat_tax'                 => ['required', 'array'],
            'vat_tax.*'               => ['required', 'string'],
            'credit_period'           => ['required', 'array'],
            'credit_period.*'         => ['required', 'string'],

            'price'                   => ['required', 'array'],
            'price.*'                 => ['required', 'numeric'],
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
            'cs_no.required'                    => 'Reference No. is required',
            'cs_no.string'                      => 'Reference No. must be a string',
            'cs_no.max'                         => 'Reference No. may not be greater than 255 characters',
            'cs_no.unique'                      => 'Reference No. has already been taken',

            'effective_date.required'           => 'Effective Date is required',
            'effective_date.date'               => 'Effective Date must be a date',
            'effective_date.date_format'        => 'Effective Date must be in the format of d-m-Y',

            'expiry_date.required'              => 'Expiry Date is required',
            'expiry_date.date'                  => 'Expiry Date must be a date',
            'expiry_date.date_format'           => 'Expiry Date must be in the format of d-m-Y',
            'expiry_date.after'                 => 'Expiry Date must be after Effective Date',

            'remarks.present'                   => 'Remarks must be present',
            'remarks.nullable'                  => 'Remarks may be null',
            'remarks.string'                    => 'Remarks must be a string',

            'material_id.required'              => 'Material is required',
            'material_id.array'                 => 'Material must be an array',
            'material_id.*.required'            => 'Material is required',
            'material_id.*.exists'              => 'Material does not exist',
            'material_id.*.distinct'            => 'Material must be distinct',

            'material_name.required'            => 'Material Name is required',
            'material_name.array'               => 'Material Name must be an array',
            'material_name.*.required'          => 'Material Name is required',
            'material_name.*.string'            => 'Material Name must be a string',

            'supplier_id.required'              => 'Supplier is required',
            'supplier_id.array'                 => 'Supplier must be an array',
            'supplier_id.*.required'            => 'Supplier is required',
            'supplier_id.*.exists'              => 'Supplier does not exist',
            'supplier_id.*.distinct'            => 'Supplier must be distinct',

            'supplier_name.required'            => 'Supplier Name is required',
            'supplier_name.array'               => 'Supplier Name must be an array',
            'supplier_name.*.required'          => 'Supplier Name is required',
            'supplier_name.*.string'            => 'Supplier Name must be a string',

            'checked_supplier.required'         => 'Checked Supplier is required',
            'checked_supplier.array'            => 'Checked Supplier must be an array',

            'vat_tax.required'                  => 'VAT/Tax is required',
            'vat_tax.array'                     => 'VAT/Tax must be an array',
            'vat_tax.*.required'                => 'VAT/Tax is required',
            'vat_tax.*.string'                  => 'VAT/Tax must be a string',

            'quotation_no.required'             => 'Quotation No. is required',
            'quotation_no.array'                => 'Quotation No. must be an array',
            'quotation_no.*.required'           => 'Quotation No. is required',
            'quotation_no.*.string'             => 'Quotation No. must be a string',

            'credit_period.required'            => 'Credit Period is required',
            'credit_period.array'               => 'Credit Period must be an array',
            'credit_period.*.required'          => 'Credit Period is required',
            'credit_period.*.string'            => 'Credit Period must be a string',

            'price.required'                    => 'Price is required',
            'price.array'                       => 'Price must be an array',
            'price.*.required'                  => 'Price is required',
            'price.*.numeric'                   => 'Price must be a number',
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
