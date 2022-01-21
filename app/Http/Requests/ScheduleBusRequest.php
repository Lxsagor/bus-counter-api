<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScheduleBusRequest extends FormRequest
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
            'bus_no'        => 'required|exists:buses,bus_no',
            'start_counter' => 'required|exists:counters,_id',
            'end_counter'   => 'required|exists:counters,_id',
            'mid_counters'  => 'required|array',
            'date'          => 'required|date',
            'time'          => 'required|date_format:H:i',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}
