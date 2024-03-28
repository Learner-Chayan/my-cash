<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [

            'price' => 'required',
            'highest_price' => 'required',
        ];
        return $rules;
    }
}
