<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:100',
            'size'          => 'required|integer',
            'measure_unit'  => 'required|string|max:10',
            'price'         => 'required|numeric',
            'active'        => 'required|boolean',
            'description'   => 'nullable|string',
        ];
    }
}
