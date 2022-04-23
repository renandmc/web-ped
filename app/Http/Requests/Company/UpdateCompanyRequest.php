<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name'              => 'required|string|max:100',
            'cnpj'              => 'required|string|max:14|unique:companies,cnpj,' . $this->company->id . ',id',
            'corporate_name'    => 'required|string|max:100|unique:companies,corporate_name,' . $this->company->id . ',id',
            'active'            => 'required|boolean'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cnpj' => str_replace(['.', '/', '-'], '', $this->cnpj)
        ]);
    }
}
