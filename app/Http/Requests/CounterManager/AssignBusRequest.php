<?php

namespace App\Http\Requests\CounterManager;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignBusRequest extends FormRequest
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
            'track_id'  => 'required|unique:assign_buses|exists:tracks,_id',
            'bus_no'    => 'required|exists:buses,bus_no',
            'bus_type'  => 'required',
            'driver_id' => 'required|exists:drivers,_id',
            'staff_id'  => 'required|exists:staff,_id',
            // 'journey_start_id' => 'required|exists:districts,_id',
            // 'journey_end_id'   => 'required|exists:districts,_id',
            // 'date_time'        => 'required',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            validateError($validator->errors())
        );
    }
}