<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApiFormRequest extends FormRequest
{

    use ResponseTrait;

    /**
     * Handle a failed validation attempt. Example if email / username doesn't provided
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->responseError(
                'Invalid form request', 
                (new ValidationException($validator))->errors(),
                Response::HTTP_BAD_REQUEST
            )
        );
    }

}
