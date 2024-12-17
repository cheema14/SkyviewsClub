<?php

/** 
 * Class: Generate Bill Controller 
 * Purpose: i- Generates bill for orders
 * ii- Prints the bill receipt 
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction; 

class GenerateBillController extends Controller
{
    public function index(Order $order)
    {

        $order = $order->load('items', 'user', 'member');

        $sum = collect($order->items)
            ->reduce(function ($carry, $item) {
                return $carry + ($item->pivot->price * $item->pivot->quantity);
            }, 0);

        $order->fill(['grand_total' => $sum, 'total' => $sum, 'status' => Order::STATUS_SELECT['Delivered']]);
        $order->update();

        // Create transactions for the order
        $order->orderTransactions()->create([
            'code' => '',
            'user_id' => auth()->user()->id,
            'type' => '',
            'status' => Transaction::STATUS_SELECT['Pending'],
        ]);

        return view('admin.bills.order_receipt', ['order' => $order, 'grand_total' => $sum, 'total' => $sum]);
    }

    public function generate_customer_bill(Order $order)
    {
        
        $order = $order->load('items', 'user', 'member', 'tableTop');
        return view('admin.bills.customer_bill', ['order' => $order, 'grand_total' => $order->grand_total, 'total' => $order->total]);
        
    }
}
