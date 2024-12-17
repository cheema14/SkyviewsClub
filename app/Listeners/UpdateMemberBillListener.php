<?php

namespace App\Listeners;

use App\Events\UpdateMemberBillEvent;
use App\Models\Bill;
use App\Models\PaymentReceipt;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMemberBillListener
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
    public function handle(UpdateMemberBillEvent $event): void
    {
        // dd($event->content);

        $receipt_data = $event->content;
        $month = Carbon::createFromFormat('Y-m',$receipt_data->billing_month)->format('m');
        
        // Find if bill exists
        $bill_exists = Bill::where('member_id',$receipt_data->member_id)->whereMonth('bill_month',$month)->get()->first();
        
        
        $billingSectionMap = [
            PaymentReceipt::BILLING_SECTION['Card'] => 'card_fee',
            PaymentReceipt::BILLING_SECTION['Practice'] => 'practice_range_coaching_fee',
            PaymentReceipt::BILLING_SECTION['Locker'] => 'locker_fee',
            PaymentReceipt::BILLING_SECTION['Others'] => 'fee',
            PaymentReceipt::BILLING_SECTION['Restaurant'] => 'restaurant_fee',
            PaymentReceipt::BILLING_SECTION['Snooker'] => 'snooker_fee',
            PaymentReceipt::BILLING_SECTION['Proshop'] => 'proshop_fee',
            PaymentReceipt::BILLING_SECTION['GolfSimulator'] => 'golf_simulator',
            PaymentReceipt::BILLING_SECTION['GolfLocker'] => 'golf_locker',
            PaymentReceipt::BILLING_SECTION['GolfCourse'] => 'golf_course',
            PaymentReceipt::BILLING_SECTION['GolfCartFee'] => 'golf_cart_fee',
            PaymentReceipt::BILLING_SECTION['GymSubscription'] => 'gym_subscription_fee',
            PaymentReceipt::BILLING_SECTION['SwimmingSubscription'] => 'swimming_subscription',
            PaymentReceipt::BILLING_SECTION['Tennischarges'] => 'tennis_charges',
            PaymentReceipt::BILLING_SECTION['Billboardcharges'] => 'bill_board_charges',
        ];

            
            $billing_section_new = $receipt_data->billing_section_new;
            // dd($billing_section_new,$bill_exists);
            if (isset($billingSectionMap[$billing_section_new]) && isset($bill_exists)) {
                
                $billing_section_new = $billingSectionMap[$billing_section_new];
                $bill_exists->$billing_section_new = $bill_exists->$billing_section_new + $receipt_data->received_amount;
                $bill_exists->total = $bill_exists->total + $receipt_data->received_amount;
                $bill_exists->net_balance_payable = $bill_exists->net_balance_payable + $receipt_data->received_amount;
                $bill_exists->save();
            }
            
        
        
    }
}
