<?php

namespace Modules\SCM\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MrrRequest extends FormRequest
{
    /**
     * Manupulate the request data before validation
     * @return void
     * 
     */
    public function prepareForValidation()
    {
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
}
