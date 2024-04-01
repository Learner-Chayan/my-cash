<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "ads_unique_num" => $this->ads_unique_num,
            "ad_type" => $this->ad_type,
            "asset_type" => $this->asset_type,
            "unit_price" => $this->unit_price,
            "highest_price" => $this->highest_price,
            "sell_price" => $this->sell_price,
            "price_type" => $this->price_type,
            "total_amount" => $this->total_amount,
            "order_limit_min" => $this->order_limit_min,
            "order_limit_max" => $this->order_limit_max,
            "date" => Carbon::parse($this->date)->format('Y-m-d h:i A'),
            "image" => $this->image
        ];
    }
}


// Name [Ad poster]
// Image [Ad Poster]
// Traders [Auto Generate for now]
// Completion [Auto Generate for now] 
// GOLD Current Price[Admin Updated]
// Total Gold for Sell
// Limit in BDT 
// Transaction Method [Halal Pay]
// Post Type[Bye/Sell]
// Post Unique ID[Auto Generated]
// Created On[Date: YYYY:MM:DD HH:MM:SS AM/PM]
