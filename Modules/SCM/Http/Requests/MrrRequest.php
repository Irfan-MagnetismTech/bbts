<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\SCM\Entities\PurchaseOrderLine;
use Illuminate\Validation\ValidationException;
use Modules\SCM\Entities\ScmMrrSerialCodeLine;

class MrrRequest extends FormRequest
{
    /**
     * Manupulate the request data before validation
     * @return void
     * 
     */
    public function prepareForValidation()
    {
        $materials = PurchaseOrderLine::join('materials', 'purchase_order_lines.material_id', '=', 'materials.id')
        ->where('purchase_order_id', $this->purchase_order_id)
        ->pluck('materials.name', 'materials.id');
        $oldInput = ['select_array' => $materials];
        request()->merge($oldInput);
                
        $values = $this->input('sl_code', []);
        $uniqueValues = array_unique(array_map('trim', $values));
        $combined = array_merge($values);
        if (array_diff_key($combined, array_unique($combined))) {
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
        $data = ScmMrrSerialCodeLine::whereIn('serial_or_drum_code', $cities)->pluck('serial_or_drum_code');
        if (count($data)) {
            throw ValidationException::withMessages(['sl_code' => 'The serial codes' . $data . 'already been taken .'])
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
            //
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
   
    public function old($key = null, $default = null)
    {
        $oldInput = array_merge(parent::old(),['irfans_try' => 'asi re vai asi']);

        Session::flashInput($oldInput);
        return array_merge(parent::old(),['irfans_try' => 'asi re vai asi']);
    }
   
}
