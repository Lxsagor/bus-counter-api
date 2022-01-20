<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        $data = [
            'name'     => 'required|regex:/^[a-zA-Z-. ]+$/u',
            'email'    => 'required|unique:users|email:rfc,dns',
            'phone'    => 'required|unique:users|regex:/(01[3-9]\d{8})$/',
            'password' => 'required|min:6',
        ];

        return $data;

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}
