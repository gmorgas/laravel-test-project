<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use LVR\CountryCode\Two;

class guestStoreRequest extends FormRequest
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
            'data.type' => 'required|in:guest',
            'data.attributes.id_number' => 'required|max:30|unique:guests,id_number',
            'data.attributes.first_name' => 'required|max:100',
            'data.attributes.last_name' => 'required|max:100',
            'data.attributes.email' => 'email|max:100|required_without:phone',
            'data.attributes.phone' => 'max:30|required_without:email',
            'data.attributes.city' => 'required|max:100',
            'data.attributes.country' => ['required', new Two]
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
            'type' => 'guest',
            'attributes' => array(
                $validator->errors()
            )
        )),422));
    }
}
