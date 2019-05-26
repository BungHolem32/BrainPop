<?php

namespace App\Http\Requests;

use App\Http\Traits\ParameterValidationTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class CustomRequest extends FormRequest
{
    use ParameterValidationTrait;

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "status"            => 422,
            "message"           => 'Please fix these errors in order to proceed',
            "errors" => $validator->errors(),
        ], 422));
    }
}
