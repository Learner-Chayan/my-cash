<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AdTransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //transaction info
            "payable_amount"        => $this->payable_amount,
            "payable_asset_type"    => $this->payable_asset_type,
            "receivable_asset_type" => $this->receivable_asset_type,
            "receivable_amount"     => $this->receivable_amount,
            "ad_trans_id"          => $this->ad_trans_id,
            "method"                => $this->method,
            "date"                  => Carbon::parse($this->date)->format('Y-m-d h:i A'),

            // ad info 
            "ads_unique_num"        => $this->ad?->ads_unique_num,
            "ad_type"               => $this->ad?->ad_type,
            "user_price"            => $this->ad?->user_price,
            "price_type"            => $this->ad?->price_type,
            "advertise_total_amount" => $this->ad?->advertise_total_amount,

            // seller
            "seller_name"           => $this->seller?->name,
            "seller_email"          => $this->seller?->email,
            "seller_image"          => $this->seller?->image,

            // buyer 
            // seller
            "buyer_name"            => $this->buyer?->name,
            "buyer_email"           => $this->buyer?->email,
            "buyer_image"           => $this->buyer?->image,
        ];
    }
}
