<?php

namespace App\Http\Resources;
use App\Enums\Status;
use App\Enums\TransactionTypeEnums;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
                "asset_type" => $this->asset_type,
                "transaction_type" => $this->transaction_type,
                "trans_id"  => $this->trans_id,
                "amount" => $this->amount,
                "status" => $this->status,
                "note"  => $this->note,
                "date"  => Carbon::parse($this->data)->format('Y-m-d h:i A'),
                "pin"   => $this->transaction_type == TransactionTypeEnums::SEND ?  $this->transactionPin?->pin : null,

                // opposite user info
                 "name" =>  $this->model?->name ?? null,
                 "payId" => $this->model?->pay_id ?? null,
                 "userType" => $this->model?->UserRoleName ?? null,
        ];
    }
}