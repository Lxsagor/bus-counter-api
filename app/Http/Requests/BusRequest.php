<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusRequest extends FormRequest
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
            'bus_no'     => 'required|numeric|unique:buses',
            'bus_reg_no' => 'required|unique:buses',
            'chesis_no'  => 'required|numeric|unique:buses',
            'bus_type'   => 'required',
            'total_seat' => 'required|numeric',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}
