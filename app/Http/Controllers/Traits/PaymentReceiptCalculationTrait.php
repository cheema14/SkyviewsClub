<?php

namespace App\Http\Controllers\Traits;

use App\Models\Bill;
use App\Models\Member;
use App\Models\Order;
use App\Models\SportsBilling;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait PaymentReceiptCalculationTrait
{
    public function calculate_bill_as_received_payment($bill,$member,$amount_received){
        
        /* 
            Here we have two cases for arrears
            1. Negative arrears - Member has paid some amount in advance
            2. Positive arrears - Member has to pay those arrears
        */
        $updated_arrears  = $remaining_balance = 0;
        
        if($member->arrears < 0){
            $advance_by_member = abs($member->arrears);
            $remaining_balance = $bill->net_balance_payable - $amount_received;
        }
        else{
            $remaining_balance = $bill->net_balance_payable - $amount_received;
        }
        // dd($amount_received,$remaining_balance);
        
        $updated_arrears = 0;

        /* 
            if $remaining_balance is:
                1. Less than 0
            This means $amount_received (Amount given by the member) is 
            higher.

                2. Equal to 0
            This means the total bill has been paid and now no arrears is left either

                3. Greater than 0
            This means the amount_received is less than actual bill. So arrears
            still remains.
        */
        // switch ($remaining_balance) {

        //     case ($remaining_balance == 0):
        //         $updated_arrears = 0;
        //         $bill->status = Bill::BILL_STATUS['Paid'];
        //         $bill->net_balance_payable = $remaining_balance;
        //         break;
        //     case ($remaining_balance > 0):
        //         $updated_arrears = $remaining_balance;
        //         $bill->net_balance_payable = $remaining_balance;
        //         $bill->status = Bill::BILL_STATUS['Partial'];
        //         break;
        //     default:
        //         $updated_arrears = $remaining_balance;
        //         $bill->net_balance_payable = 0;
        //         $bill->status = Bill::BILL_STATUS['Paid'];
                
        // }
        if ($remaining_balance == 0.0 || $remaining_balance == 0) {
            $updated_arrears = 0;
            $bill->status = Bill::BILL_STATUS["Paid"];
            $bill->net_balance_payable = $remaining_balance;
            $bill->save();
        } 
        elseif ($remaining_balance > 0) {
            $updated_arrears = $remaining_balance;
            $bill->net_balance_payable = $remaining_balance;
            $bill->status = Bill::BILL_STATUS["Partial"];
            $bill->save();
        } 
        elseif ($remaining_balance < 0) {
            $updated_arrears = $remaining_balance;
            $bill->net_balance_payable = 0;
            $bill->status = Bill::BILL_STATUS["Paid"];
            $bill->save();
        } 
        else {
            $updated_arrears = $remaining_balance;
            $bill->net_balance_payable = 0;
            $bill->status = Bill::BILL_STATUS["Paid"];
            $bill->save();
        }
        
        $member->previous_paid_arrears = $member->arrears; // To be used in PDFs of bills
        $member->arrears = $updated_arrears;
        $member->save();
        
        
        
        
    }
}
