<?php

namespace Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Sales\Entities\Product;

class ConnectivityRequirementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function prepareForValidation()
    {
        $product_id = [];
        foreach ($this->input('category_id') as $key => $value) {
            $product_id[] = Product::where('category_id', $value)->pluck('id', 'name')->toArray();
        }
        request()->merge(['product_select' => $product_id]);
    }

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
