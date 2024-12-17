<?php

namespace App\Listeners;

use App\Events\UpdateMemberArrearEvent;
use App\Models\Bill;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMemberArrearListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateMemberArrearEvent $event): void
    {
        $monthly_bill_object = $event->content;
        $member_id = Member::where('membership_no',$monthly_bill_object->membership_no)->get()->pluck('id')->first();
        
        // dd($event,$monthly_bill_object,$event->update_call);
        
        $month = Carbon::createFromFormat('Y-m-d',$monthly_bill_object->bill_date)->format('m');
        
        // Find if bill exists
        $bill_exists = Bill::where('member_id',$member_id)->whereMonth('bill_month',$month)->get()->first();
        /* 
            balance_bfcr -> 1000      new-> 3000
            total -> 6500        
            
            balance_bfcr -> 3000
            total -> 6500 - 1000 + 3000
        */
        if($bill_exists){

            // $event->update_call means 
            // that the balance_bfcr exists already in the bill
            // but we are updating it. 
            // see the case above

            if($event->update_call){
                $bill_exists->total = $bill_exists->total - $bill_exists->balance_bfcr + $monthly_bill_object->billing_amount;
                $bill_exists->net_balance_payable = $bill_exists->net_balance_payable - $bill_exists->balance_bfcr  + $monthly_bill_object->billing_amount;
                $bill_exists->balance_bfcr = $monthly_bill_object->billing_amount;
                $bill_exists->save();
            }
            else{
                $bill_exists->balance_bfcr += $monthly_bill_object->billing_amount;
                $bill_exists->total += $monthly_bill_object->billing_amount;
                $bill_exists->net_balance_payable += $monthly_bill_object->billing_amount;
                $bill_exists->save();
            }

        }
        
    }
}
