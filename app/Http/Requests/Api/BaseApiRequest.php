<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

abstract class BaseApiRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        Log::warning($this->route()->getActionName().' request with invalid data detail: ', $validator->errors()->toArray());
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST));
    }
}
