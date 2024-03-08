<?php

namespace App\Http\Resources;
use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                "sender" => new UserResource($this->sender),
                "receiver" => new UserResource($this->receiver),
                "asset_type" => $this->asset_type,
                "transaction_type" => $this->transaction_type,
                "amount" => $this->amount,
                "status" => $this->status,
                "note"  => $this->note
        ];
    }
}

