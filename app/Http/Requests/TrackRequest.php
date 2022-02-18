<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TrackRequest extends FormRequest
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
            'route'    => 'required|array',
            'bus_type' => 'required',
            'day_time' => 'array',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}