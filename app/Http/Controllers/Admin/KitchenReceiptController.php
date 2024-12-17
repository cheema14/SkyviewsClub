<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use App\Printing\ReceiptPrinter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class KitchenReceiptController extends Controller
{
    public function index(Order $order){

        $menu_id = auth()->user()->roles()->first()?->menus()->get()->pluck('id');
        
        // In case any dickhead(qa or a user) tries to check a kitchen receipt of a completed order
        // instead of accessing its cash receipt
        if($order->status == Order::STATUS_SELECT["Complete"]){
            return redirect()->route('admin.orders.index')->with('completedOrderCantView','The order is complete. Cannot view its kitchen receipt.');
        }

        if($order->status == Order::STATUS_SELECT['Active']){
            
            if($menu_id){
                $data = $order->load(['items' => function ($query) use ($menu_id) {
                    $query->whereIn('menu_id', $menu_id);
                }, 'tableTop']);
    
            }
            else{
                $data = $order->load('items','tableTop');
            }
        }
        elseif($order->status == Order::STATUS_SELECT['InProgress']){
            
            if ($menu_id) {
                $data = $order->load(['items' => function ($query) use ($menu_id) {
                    $query->whereIn('menu_id', $menu_id)
                          ->where(function($query) {
                              $query->where('new_added_item', 'yes')
                                    ->orWhere('new_quantity', '>', 0);
                          });
                }, 'tableTop']);
               
            } 
            else {
                $data = $order->load(['items' => function ($query) {
                    $query->where(function($query) {
                        $query->where('new_added_item', 'yes')
                              ->orWhere('new_quantity', '>', 0);
                    });
                }, 'tableTop']);
            }
            
            // Now update the new_added and new_quantity so that it doesn't come again
            // Update related 'items' in the pivot table
            foreach ($order->items as $item) {
                // Check if the item has 'new_added_item' = 'yes' or 'new_quantity' > 0
                if ($item->pivot->new_added_item == 'yes' || $item->pivot->new_quantity > 0) {
                    // Update the pivot values
                    $order->items()->updateExistingPivot($item->id, [
                        'new_added_item' => 'no',  // Set new_added_item to 'no'
                        'new_quantity' => 0        // Set new_quantity to 0
                    ]);
                }
            }

        }

 
        if($order->status == Order::STATUS_SELECT['Active']){
            $order->fill(['status' => Order::STATUS_SELECT['InProgress']]);   
            $order->update();
        }
        
        return view('admin.bills.kitchen_receipt',['data'=>$data,'menu_id'=>$menu_id]);
    }

    public function kitchen_order_history(Order $order){
        
        $history = array();
        $menu_id = auth()->user()->roles()->first()?->menus()->get()->pluck('id');
        $order->load('kitchenOrderHistory');
        $count = 1;

        foreach($order->kitchenOrderHistory as $value){
            $history[$count] = json_decode($value->items_data,true);
            $count++;
        }

        dd($history);
    }
}
