<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\TableTop;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CashReceiptController extends Controller
{


    public function create_cash_receipt(Order $order){
        
        $menu_id = auth()->user()->roles()->first()?->menus()->get()->first()?->id;
        $order = $order->load('items','user', 'member');

        $total_deals_amount = $this->check_discounted_menu_item($order);
        
        $check_discounted_item = $this->check_discounted_menu_item_front_end($order->items);

        if($order->status != Order::STATUS_SELECT['InProgress']){
            return 'Please mark the order complete before printing the bill.';   
        }

        $sum = collect($order->items)
                ->reduce(function($carry, $item){
                return $carry + ($item->pivot->price * $item->pivot->quantity);
            }, 0);
        
            

            
        return view('admin.receipts.create_receipt',['order'=>$order,'grand_total'=>$sum,
        'total'=>$sum, 'total_deals_amount'=>$total_deals_amount, 'check_discounted_item'=> $check_discounted_item]);
    }

    public function store_receipt(Order $order, Request $request){
        
        $items = $order->load('items');
        
        $menu_check = $items->items;
        $menu_check = $this->check_discounted_menu_item($items);

        // dd($menu_check,$order->grand_total);

        $order = $order->load('items','user','orderTransactions');
        // Find transaction from order id then fill properties
        $discount = 0;

        if($request->discount){
            
            $discount = $request->discount;

            $discountAmount = ($discount / 100) * ($order->grand_total - $menu_check);
            $order->discount = $discountAmount;
            $order->item_discount = $request->discount;
            $order->grand_total = $order->grand_total - $discountAmount;

        }


        // Find if pay mode is card
        // 31 Jan 2024 - Card charges removed so 
        // if statement is put to false
        // if($request->pay_mode == "Card" || false){
        //     $bank_charges = 2.37;
        //     $b_charges = ($order->grand_total * 2.37) / 100;

        //     $order->fill(['grand_total' => $order->grand_total + $b_charges, 'tax'=>$b_charges ]);
        //     $order->update();
        // }

        // if($request->pay_mode == "Creditor"){

        //     $cafe_charges = $order->grand_total;

        // }

        $order->orderTransactions()->create([
            'code'=>'',
            'user_id'=>auth()->user()->id,
            'type'=>$request->pay_mode,
            'status'=> Transaction::STATUS_SELECT['Success'],
            'bill_amount'=> $order->grand_total
        ]);


        $order->fill(['status' => Order::STATUS_SELECT['Complete'],'payment_type' => $request->pay_mode]);
        $order->update();

        
        $tableTop = TableTop::find($order->tableTop->id);
        $tableTop->fill(['status'=> 'free']);
        $tableTop->update();


        // return redirect()->route('admin.print-customer-bill' , $order->id);
        return "<script>window.open('" . route('admin.print-customer-bill', $order->id) . "', '_blank'); window.close();</script>";

    }

    public function check_discounted_menu_item($itemsArray){
        
        
        $check_discounted = array();
        foreach($itemsArray->items as $key=>$items){
            
            $check = Menu::where('id',$items->pivot->menu_id)->where('has_discount',1)->get();
            
            if($check->isNotEmpty()){
                $check_discounted[]= $items;
            }
        }

        // The sum of the amount that shouldn't be handled in discount
        
        $sum = collect($check_discounted)
            ->reduce(function ($carry, $item) {
                // dd($item->pivot->price);
                return $carry + ($item->pivot->price * $item->pivot->quantity);
            }, 0);
        
        
        return $sum;
    }

    public function check_discounted_menu_item_front_end($itemsArray){
        
        $check_discounted = false;
        foreach($itemsArray as $key=>$items){
            
            $check = Menu::where('id',$items->pivot->menu_id)->where('has_discount',1)->get();
            if($check->isNotEmpty()){
                $check_discounted = true;
            }
        }
        
        return $check_discounted;
    }

}
