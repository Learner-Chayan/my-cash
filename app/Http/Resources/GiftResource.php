<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "identifier" => $this->identifier,
            "asset_type" => $this->asset_type,
            "gift_type" => $this->gift_type,
            "amount" => $this->amount,
            "date" => $this->date,
            "status" => $this->status
        ];
    }
}

