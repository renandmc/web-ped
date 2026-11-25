<?php

namespace App\Http\Requests\CompanyAddress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyAddressRequest extends FormRequest
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
            'cep'           => 'required|string|max:8',
            'street'        => 'required|string|max:200',
            'number'        => 'nullable|string|max:20',
            'neighborhood'  => 'required|string|max:200',
            'city'          => 'required|string|max:200',
            'state'         => 'required|string|max:2',
            'notes'         => 'nullable|string',
            'active'        => 'required|boolean'
        ];
    }
}
