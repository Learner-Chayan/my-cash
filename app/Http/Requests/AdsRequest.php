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
            "ad_type" => ['required'],
            "asset_type" => ['required'],
            "advertise_total_amount" => ["required", "min:0.1"],
            "user_price" => ["required", "min:0.1"],
            "price_type" => ["required"],
            "order_limit_min" => ["required"],
            "order_limit_max" => ["required"],
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
// "advertise_total_amount",
// "ad_type",
// "asset_type",
// order_limit_min
// order_limit_max