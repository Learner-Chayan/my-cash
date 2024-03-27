<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
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
