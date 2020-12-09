<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoomsStoreRequest extends FormRequest
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
            'data.attributes.type' => 'required',
            'data.attributes.number' => 'required|integer',
            'data.attributes.floor' => 'required|integer',
            'data.attributes.price_default' => 'required|numeric'
        ];
    }

    /**
     * Set up messages for errors
     *
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'data.attributes.type.required' => 'Type is required',
            'data.attributes.number.required' => 'Number is required',
            'data.attributes.number.integer' => 'Number is not a number',
            'data.attributes.floor.required' => 'Floor is required',
            'data.attributes.floor.integer' => 'Floor is not a number',
            'data.attributes.price_default.required' => 'Default price is required',
            'data.attributes.price_default.numeric' => 'Default price is not a number',
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
            'type' => 'rooms',
            'attributes' => array(
                $validator->errors()
            )
        )),422));
    }
}
