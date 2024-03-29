<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Validation\ValidationException;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\ScmMrrSerialCodeLine;

class ScmMrrRequest extends FormRequest
{
    /**
     * Manupulate the request data before validation
     * @return void
     * 
     */
    public function prepareForValidation()
    {
        $materials = PurchaseOrderLine::query()
            ->with('material')
            ->join('materials', 'purchase_order_lines.material_id', '=', 'materials.id')
            ->where('purchase_order_id', $this->purchase_order_id)
            ->get()
            ->unique('material_id');
        $oldInput = ['select_array' => $materials];
        request()->merge($oldInput);

        $values = $this->input('sl_code', []);
        $uniqueValues = array_unique(array_map('trim', $values));
        $combined = array_merge($values);
        $diff = array_diff_key($combined, array_unique($combined));
        $diffWithoutNull = array_filter($diff, function ($value) {
            return !is_null($value);
        });


        if ($diffWithoutNull) {
            throw ValidationException::withMessages(['sl_code' => 'The input contains duplicate values.'])
                ->redirectTo($this->getRedirectUrl());
        }

        $cities = [];
        foreach ($uniqueValues as $item) {
            $cities = array_merge($cities, explode(',', $item));
        }
        $uniqueValues = array_unique($cities);
        if (array_diff_assoc($cities, $uniqueValues)) {
            throw ValidationException::withMessages(['sl_code' => 'The input contains duplicate values.'])
                ->redirectTo($this->getRedirectUrl());
        }
        if (request()->method() == "POST") {
            $data = ScmMrrSerialCodeLine::whereIn('serial_or_drum_key', $cities)->whereNot('serial_or_drum_key', '')->pluck('serial_or_drum_key');
            if (count($data)) {
                throw ValidationException::withMessages(['sl_code' => 'The serial codes' . $data . 'already been taken .'])
                    ->redirectTo($this->getRedirectUrl());
            }
        } else {
            // $id = request()->route('material_receive')->id;
            // $excludedIds = ScmMrrSerialCodeLine::whereHas('scmMrrLines', function ($item) use ($id) {
            //     return $item->where('scm_mrr_id', $id);
            // })->pluck('id');
            //     $data = ScmMrrSerialCodeLine::whereIn('serial_or_drum_key', $cities)
            //     ->whereNot('serial_or_drum_key', '')
            //     ->whereNotIn('id', $excludedIds)
            //     ->pluck('serial_or_drum_key');

            $id = request()->route('material_receive')->id;
            $excludedKeys = ScmMrrSerialCodeLine::whereHas('scmMrrLines', function ($item) use ($id) {
                return $item->where('scm_mrr_id', $id);
            })->pluck('serial_or_drum_key');
            $data = ScmMrrSerialCodeLine::whereIn('serial_or_drum_key', $cities)
                ->whereNot('serial_or_drum_key', '')
                ->whereNotIn('serial_or_drum_key', $excludedKeys)
                ->pluck('serial_or_drum_key');
            if (count($data)) {
                throw ValidationException::withMessages(['sl_code' => 'The serial-- codes' . $data . 'already been taken .'])
                    ->redirectTo($this->getRedirectUrl());
            }
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
            'branch_id' => 'required',
            'date' => 'required',
            'purchase_order_id' => 'required',
            'supplier_id' => 'required',
            'total_amount' => 'required',
            'material_id.*' => 'required',
            'brand_id.*' => 'required',
            'model.*' => 'required',
            // 'quantity.*' => 'required',
            // 'amount.*' => 'required'
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
            'branch_id.required' => 'Brand is Required',
            'purchase_order_id.required' => 'Po No is Required',
            'supplier_id.required' => 'Supplier is Required',
            'material_id.*.required' => 'Material is required'
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
