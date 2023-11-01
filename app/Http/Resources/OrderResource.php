<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            "item_discount" => $this->item_discount,
            "sub_total" => $this->sub_total,
            "tax" => $this->tax,
            "total" => $this->total,
            "promo" => $this->promo,
            "discount" => $this->discount,
            "grand_total" => $this->grand_total,
            "user_id" => $this->user_id,
            "member_id"=> $this->member_id,
            "membership_no"=> $this->member?->membership_no,
            "no_of_guests" => $this->no_of_guests,
            "table_top_id" => $this->table_top_id,
            "items" => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
