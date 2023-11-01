<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\TableTop;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashReceiptController extends Controller
{


    public function create_cash_receipt(Order $order){

        $order = $order->load('items','user', 'member');

        $sum = collect($order->items)
                ->reduce(function($carry, $item){
                return $carry + ($item->pivot->price * $item->pivot->quantity);
            }, 0);

        return view('admin.receipts.create_receipt',['order'=>$order,'grand_total'=>$sum,'total'=>$sum]);
    }

    public function store_receipt(Order $order, Request $request){

        $order = $order->load('items','user','orderTransactions');
        // Find transaction from order id then fill properties



        // Find if pay mode is card
        if($request->pay_mode == "Card"){
            $bank_charges = 2.37;
            $b_charges = ($order->grand_total * 2.37) / 100;

            $order->fill(['grand_total' => $order->grand_total + $b_charges, 'tax'=>$b_charges ]);
            $order->update();
        }

        // if($request->pay_mode == "Creditor"){

        //     $cafe_charges = $order->grand_total;

        // }

        $order->orderTransactions()->create([
            'code'=>'',
            'user_id'=>auth()->user()->id,
            'type'=>$request->pay_mode,
            'status'=> Transaction::STATUS_SELECT['Success']
        ]);


        $order->fill(['status' => Order::STATUS_SELECT['Complete']]);
        $order->update();

        $tableTop = TableTop::find($order->tableTop->id);
        $tableTop->fill(['status'=> 'free']);
        $tableTop->update();


        return redirect()->route('admin.print-customer-bill' , $order->id);
        // return redirect()->route('admin.orders.index');
    }
}
