<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PurchaseOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'remarks' => 'required',
            // 'po_number' => 'required',
            // 'po_date' => 'required',
            // 'supplier_id' => 'required',
            // 'po_status' => 'required',
            // 'po_type' => 'required',
            // 'po_tax' => 'required',
            // 'po_tax_amount' => 'required',
            // 'po_sub_total' => 'required',
            // 'po_total' => 'required',
            // 'po_discount' => 'required',
            // 'po_discount_amount' => 'required',
            // 'po_grand_total' => 'required',
            // 'po_payment_status' => 'required',
            // 'po_payment_method' => 'required',
            // 'po_payment_date' => 'required',
            // 'po_payment_amount' => 'required',
            // 'po_payment_note' => 'required',
            // 'po_note' => 'required',
            // 'po_attachment' => 'required',
            // 'po_attachment.*' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:2048',
            // 'po_item' => 'required',
            // 'po_item.*.material_id' => 'required',
            // 'po_item.*.material_name' => 'required',
            // 'po_item.*.material_quantity' => 'required',
            // 'po_item.*.material_unit' => 'required',
            // 'po_item.*.material_price' => 'required',
            // 'po_item.*.material_tax' => 'required',
            // 'po_item.*.material_tax_amount' => 'required',
            // 'po_item.*.material_sub_total' => 'required',
            // 'po_item.*.material_total' => 'required',
            // 'po_item.*.material_discount' => 'required',
            // 'po_item.*.material_discount_amount' => 'required',
            // 'po_item.*.material_grand_total' => 'required',
            // 'po_item.*.material_note' => 'required',
            // 'po_item.*.material_attachment' => 'required',
            // 'po_item.*.material_attachment.*' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:2048',
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
            'remarks.required' => 'Remarks is required',
            // 'po_number.required' => 'PO Number is required',
            // 'po_date.required' => 'PO Date is required',
            // 'supplier_id.required' => 'Supplier is required',
            // 'po_status.required' => 'PO Status is required',
            // 'po_type.required' => 'PO Type is required',
            // 'po_tax.required' => 'PO Tax is required',
            // 'po_tax_amount.required' => 'PO Tax Amount is required',
            // 'po_sub_total.required' => 'PO Sub Total is required',
            // 'po_total.required' => 'PO Total is required',
            // 'po_discount.required' => 'PO Discount is required',
            // 'po_discount_amount.required' => 'PO Discount Amount is required',
            // 'po_grand_total.required' => 'PO Grand Total is required',
            // 'po_payment_status.required' => 'PO Payment Status is required',
            // 'po_payment_method.required' => 'PO Payment Method is required',
            // 'po_payment_date.required' => 'PO Payment Date is required',
            // 'po_payment_amount.required' => 'PO Payment Amount is required',
            // 'po_payment_note.required' => 'PO Payment Note is required',
            // 'po_note.required' => 'PO Note is required',
            // 'po_attachment.required' => 'PO Attachment is required',
            // 'po_attachment.*.mimes' => 'PO Attachment must be a file of type: jpeg, jpg, png, pdf, doc, docx.',
            // 'po_attachment.*.max' => 'PO Attachment may not be greater than 2048 kilobytes.',
            // 'po_item.required' => 'PO Item is required',
            // 'po_item.*.material_id.required' => 'Material is required',
            // 'po_item.*.material_name.required' => 'Material Name is required',
            // 'po_item.*.material_quantity.required' => 'Material Quantity is required',
            // 'po_item.*.material_unit.required' => 'Material Unit is required',
            // 'po_item.*.material_price.required' => 'Material Price is required',
            // 'po_item.*.material_tax.required' => 'Material Tax is required',
            // 'po_item.*.material_tax_amount.required' => 'Material Tax Amount is required',
            // 'po
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

    public function validate(): void
    {
        $validator = Validator::make($this->input(), $this->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function hasErrors(): bool
    {
        return Validator::make($this->input(), $this->rules())->fails();
    }
}
