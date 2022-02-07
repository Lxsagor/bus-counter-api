<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CounterRequest extends FormRequest
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
            'division_id'  => 'required|exists:divisions,_id',
            'district_id'  => 'required|exists:districts,_id',
            'name'         => 'required',
            'manager_name' => 'required|regex:/^[a-zA-Z-. ]+$/u',
            'phone'        => 'required|unique:users|regex:/(01[3-9]\d{8})$/',
            'password'     => 'required|min:6',
            // 'go_through'   => 'array',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}