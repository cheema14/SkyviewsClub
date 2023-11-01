<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\MenuItemCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'title' => $this->title,
            'menu_categories' => MenuItemCategoryResource::collection($this->whenLoaded('menuCategories'))
        ];
    }
}
