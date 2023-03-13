<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
        // $old = session()->getOldInput();
        // $data = app('request')->old();
        // $oldMaterialBrand = $this->getOldInput('material_brand');
        // dd($oldMaterialBrand);
        // dump($data);
        // dump($old);
        // dump(old());
        $materialBrand = old('material_brand', 'default_value_if_not_found');

        // Set the old value for material_brand input
        Session::flashInput(['material_brand' => 'dfsdf']);
        // Session::flashInput(['material_brand' => 'xcvxcvxcv']);
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
    public function getResponse()
    {
        dd($this->response);
    }
}
