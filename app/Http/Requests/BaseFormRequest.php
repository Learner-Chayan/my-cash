<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }
}
