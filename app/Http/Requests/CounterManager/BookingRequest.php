<?php

namespace App\Http\Requests\CounterManager;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookingRequest extends FormRequest
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
            'seat_no' => 'required',
            'fare'    => 'required',
            'phone'   => 'required|regex:/(01[3-9]\d{8})$/',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}