<?php

namespace App\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                "id" => $this->id ?? null,
                "name" => trim($this->name, " ") ? $this->name : null,
                "email" => $this->email ? $this->email :  null,
                "phone" => $this->phone ? $this->phone : null,
                "pay_id" => $this->pay_id ? $this->pay_id : null,
                "verified" => $this->status == Status::ACTIVE ? true : false,
                "account_type" =>  $this->UserRoleName,
                "image" => $this->image

        ];
    }
}
