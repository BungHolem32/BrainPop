<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class CustomRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "status"            => 422,
            "message"           => 'Please fix these errors in order to proceed',
            "errors" => $validator->errors(),
        ], 422));
    }

    /**
     * @return array
     */
    protected function validationData()
    {
        $data = $this->all();
        $data = array_merge($data, $this->route()->parameters);

        return $data;
    }

}
