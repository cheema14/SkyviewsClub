<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name,
            'menu_id' => $this->whenPivotLoaded('menu_menu_item_category', function () {
                return $this->pivot->menu_id;
            }),
            'deleted_at' => $this->delete_at
        ];
    }
}
