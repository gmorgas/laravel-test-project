<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservationConfirmRequest extends FormRequest
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
            'data.type' => 'required|in:reservations',
            'data.id' => 'required|integer',
            'data.attributes.room_id' => 'required_with:attributes|integer',
        ];
    }

    /**
     * Return the validations errors in json
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(array('data' => array(
            'type' => 'reservations',
            'attributes' => array(
                $validator->errors()
            )
        )),422));
    }
}
