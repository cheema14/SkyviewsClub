<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\LiveOrder;
use App\Events\OrderUpdated;
use App\Events\PrintUpdatedKitchenReceiptEvent;
use App\Events\StagingOrder;
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

        $new_items_ids = array();
        $quantity_changed_items_ids = array();
        // Initialize arrays to track new and modified items
        $newItems = [];
        $modifiedItems = array();
        

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
                    $modifiedItems = $requestItem;
                    $modifiedItems['new_quantity'] = $requestItem['quantity'] - $itemExists->pivot->quantity;
                    
                    array_push($quantity_changed_items_ids,$requestItem['item_id']);
                }
            } else {
                // Item does not exist in the existingItems collection
                // It's a new item, add it to the newItems array

                // In the new_items_ids array we are pushing those items
                // which are newly added in an order
                // In order to print a New label with them or a new receipt entirely
                array_push($new_items_ids,$requestItem['item_id']);
                $newItems[] = $requestItem;
            }
        }
        $newAndModifiedItems['newAndModifiedItems'] = array_merge($newItems, $modifiedItems);
        
        $data = $order->load('items', 'tableTop');

        $newAndModifiedItems['data'] = $data;
        
        
        // foreach ($newAndModifiedItems['newAndModifiedItems'] as $key => $value) {
        //     $recieptData['menu'.$value['menu_id']][] = $value;
        // }

        // $recieptData['tableTop'] = $order->tableTop;
        // $recieptData['orderDetails'] = $order->id;

        // PrintUpdatedKitchenReceiptEvent::dispatch($recieptData);
        
        
        // foreach ($request->items as &$item) {
        //     if (in_array($item['item_id'], $new_items_id)) {
        //         $item['new_added_item'] = 'yes';
        //     } else {
        //         $item['new_added_item'] = 'no';
        //     }
        // }
        
        $modified_labels = array_map(function($item) use ($new_items_ids, $quantity_changed_items_ids, $modifiedItems) {
            // Mark new added item
            $item['new_added_item'] = in_array($item['item_id'], $new_items_ids) ? 'yes' : 'no';
            
            $item['new_quantity'] = in_array($item['item_id'], $quantity_changed_items_ids) ? $modifiedItems['new_quantity'] : 0;
            
            // Initialize new_quantity to 0
            // $item['new_quantity'] = 0;
        
            if (in_array($item['item_id'], $quantity_changed_items_ids)) {
                
            }
        
            return $item;
        }, $request->items);
        
        
        
        // dd($modified_labels,$modifiedItems['item_id']);
        $order
            ->items()
            ->sync($this->mapItemValues($modified_labels));

        $this->calculate_total_after_update_order($request->items, $order);

        // $kitchen_order = new KitchenOrderHistory();
        // $kitchen_order->order_id = $order->id;
        // $kitchen_order->items_data = json_encode($modified_labels,TRUE);
        // $kitchen_order->save();
        
        // Broadcast the order update event
        if(config('app.env') == 'production'){
            broadcast(new LiveOrder($order));
        }
        elseif(config('app.env') == 'staging'){
            broadcast(new StagingOrder($order));
        }
        else{
            broadcast(new OrderUpdated($order));
        }
       

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
                'new_quantity' => $itemAttributes['new_quantity'],
                'content' => $itemAttributes['content'],
                'price' => $itemAttributes['price'],
                'menu_id' => $itemAttributes['menu_id'],
                'new_added_item' => $itemAttributes['new_added_item'],
                'title' => $itemAttributes['title'],
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
