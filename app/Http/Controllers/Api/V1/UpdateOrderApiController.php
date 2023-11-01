<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\PrintUpdatedKitchenReceiptEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiResponser;
use App\Models\Order;
use App\Models\TableTop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateOrderApiController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'items' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $order = Order::find($request->order_id);

        //  Now find the new items in request or modified items

        $requestItems = $request->items;
        // Get the existing items from the order
        $existingItems = $order->items;
        // dd($existingItems[0]->pivot);

        // Initialize arrays to track new and modified items
        $newItems = [];
        $modifiedItems = [];

        // Iterate through the request items to identify new and modified items

        foreach ($requestItems as $requestItem) {
            $itemExists = $existingItems->first(function ($existingItem) use ($requestItem) {
                return $existingItem->pivot->item_id === $requestItem['item_id'];
            });

            if ($itemExists) {
                // Item exists, check if quantity has changed
                if ($itemExists->pivot->quantity !== $requestItem['quantity']) {
                    // Quantity has changed, add to modifiedItems array
                    // $modifiedItems[] = $itemExists;
                    $modifiedItems[] = $requestItem;
                }
            } else {
                // Item does not exist in the existingItems collection
                // It's a new item, add it to the newItems array
                $newItems[] = $requestItem;
            }
        }

        $newAndModifiedItems = array_merge($newItems, $modifiedItems);
        $data = $order->load('items', 'tableTop');

        $newAndModifiedItems['data'] = $data;

        PrintUpdatedKitchenReceiptEvent::dispatch($newAndModifiedItems);

        return $this->success(
            ['order' => $order], trans('apis.order.save')
        );
    }

    protected function mapItemValues($items)
    {

        $syncData = collect($items)->mapWithKeys(function ($itemAttributes, $itemId) {

            return [$itemAttributes['item_id'] => [
                // return [$itemId => [
                'quantity' => $itemAttributes['quantity'],
                'content' => $itemAttributes['content'],
                'price' => $itemAttributes['price'],
                'menu_id' => $itemAttributes['menu_id'],
            ]];
        })->all();

        return $syncData;
    }

    protected function calculate_total_after_update_order($items, Order $order)
    {

        // dd($items);
        $sum = collect($items)
            ->reduce(function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

        $order->fill(['grand_total' => $sum, 'total' => $sum]);
        $order->update();
    }

    public function updateOrderStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $order = Order::find($request->order_id);

        if ($order->status == 'Active') {

            $order->fill(['status' => 'Delivered']);
            $order->update();

        } else {

            $order->fill(['status' => 'Complete']);
            $order->update();

            $tableTop = TableTop::find($order->tableTop->id);
            $tableTop->fill(['status' => 'free']);
            $tableTop->update();
        }

        return $this->success(
            ['order' => $order], trans('apis.orderStatus.statusChanged')
        );

    }
}
