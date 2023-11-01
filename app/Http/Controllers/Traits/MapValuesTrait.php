<?php

namespace App\Http\Controllers\Traits;

use App\Models\Item;
use Illuminate\Http\Request;

trait MapValuesTrait
{
    public function mapItemValues($items)
    {
        foreach ($items as $key => $value) {
            $itemsArray[] = Item::find($value)->first();
        }

        $syncData = collect($itemsArray)->mapWithKeys(function ($itemAttributes, $itemId) {
            // dd($itemAttributes[]);
            return [$itemAttributes['id'] => [
            // return [$itemId => [
                'quantity' => 1,
                'content' => 'Added to existing order',
                'price' => $itemAttributes['price'],
                'item_id' => $itemAttributes['id'],
            ]];
        })->all();
        // dd($syncData);
        return $syncData;
    }
}
