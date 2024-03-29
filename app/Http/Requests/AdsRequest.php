<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
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
        return [  
            "ad_type" => ['required','numeric'],
            "asset_type" => ['required','numeric'],
            "total_amount" => ["required", "numeric", "min:0.1"],
            "sell_price" => ["required", "numeric", "min:0.1"],
            "price_type" => ["required", "numeric"],
        ];
    }
}


// "user_id",
// "ads_unique_num",
// "status",
// "date",

// "unit_price",
// "highest_price",


//from request ---------
// "sell_price",
// "price_type",
// "total_amount",
// "ad_type",
// "asset_type",