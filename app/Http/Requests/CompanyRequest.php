<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyRequest extends FormRequest
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
            'name'           => 'required|regex:/^[a-zA-Z-. ]+$/u',
            'email'          => 'required|unique:companies|email:rfc,dns',
            'phone'          => 'required|unique:companies|regex:/(01[3-9]\d{8})$/',
            'no_of_counters' => 'required',
            'sub_start_date' => 'required|date',
            'sub_end_date'   => 'required|date',
        ];

        if (request()->method() === 'PATCH') {
            $data['email'] = 'unique:companies|email:rfc,dns';
            $data['phone'] = 'unique:companies|regex:/(01[3-9]\d{8})$/';
        }

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}
