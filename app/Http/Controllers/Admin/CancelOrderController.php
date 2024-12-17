<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CancelOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,Order $order)
    {
        $order->status = Order::STATUS_SELECT["Cancelled"];
        $order->save();

        // dd($order->load('orderTransactions'));

        return back()->with('ordercancelled', 'Order Cancelled successfully.');
    }
}
