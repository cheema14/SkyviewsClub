<?php

namespace App\Listeners;

use App\Events\DiscountedMembershipFeeEvent;
use App\Models\Bill;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DiscountedMembershipFeeListener
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
    public function handle(DiscountedMembershipFeeEvent $event): void
    {
        $member_id = $event->content['member_id'];
        $month = Carbon::now()->format('m');
        
        $member = Member::where('id',$member_id)->get()->first();
        
        $bill_exists = Bill::where('member_id',$member_id)->whereMonth('bill_month',$month)->get()->first();
        // dd("coming in case of new absentee creation");
        if($bill_exists && !$event->content['absentees_monthly_subscription']){

            
            if($event->content['update_call']){
                $bill_exists->total = $bill_exists->total - $bill_exists->monthly_subscription + $member->monthly_subscription;
                $bill_exists->net_balance_payable = $bill_exists->net_balance_payable - $bill_exists->monthly_subscription + + $member->monthly_subscription;
                $bill_exists->monthly_subscription = $member->monthly_subscription;
                $bill_exists->save();
            }
            else{
                $bill_exists->monthly_subscription +=  $member->monthly_subscription;
                $bill_exists->total += $member->monthly_subscription;
                $bill_exists->net_balance_payable += $member->monthly_subscription;
                $bill_exists->save();
            }

        }
        
        if($bill_exists && !$event->content['update_call'] && $event->content['absentees_monthly_subscription']){
            $bill_exists->total = $bill_exists->total - $bill_exists->monthly_subscription + $event->content['monthly_subscription'];
            $bill_exists->net_balance_payable = $bill_exists->net_balance_payable - $bill_exists->monthly_subscription + $event->content['monthly_subscription'];
            $bill_exists->monthly_subscription = $event->content['monthly_subscription'];
            $bill_exists->save();
        }
    }
}
