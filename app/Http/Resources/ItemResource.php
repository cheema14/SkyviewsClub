<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'item_id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'price' => $this->price,
            'quantity' => $this->pivot->quantity,
            'new_quantity' => $this->pivot->new_quantity,
            'category_id' => $this->menu_item_category?->id,
            'order_id' => $this->pivot->order_id,
            'content' => $this->pivot->content,
            'menu_id' => $this->pivot->menu_id
        ];
    }
}
