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
            "user_price" => ["required", "numeric", "min:0.1"],
            "price_type" => ["required", "numeric"],
            "order_limit_min" => ["required", "numeric"],
            "order_limit_max" => ["required", "numeric"],
        ];
    }
}


// "user_id",
// "ads_unique_num",
// "status",
// "date",

// "unit_price_floor",
// "unit_price_ceil",

//from request ---------
// "sell_price", user_price
// "price_type",
// "total_amount",
// "ad_type",
// "asset_type",
// order_limit_min
// order_limit_max