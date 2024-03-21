<?php

namespace App\Http\Controllers\Traits;

use App\Models\Member;
use App\Models\Order;
use App\Models\SportsBilling;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait CalculateBills
{
    public function calculate_montly_bills($month)
    {
        
        $total_bill = 0;

        $currentMonth = Carbon::now();
        $firstDayOfPreviousMonth = $currentMonth->subMonth()->startOfMonth();
        $lastDayOfPreviousMonth = $currentMonth->endOfMonth();

        $members = Member::where('membership_status',Member::MEMBERSHIP_STATUS_SELECT['Active'])->get();
        
        foreach($members as $key=>&$member){
            
            $total_bill = Order::whereHas('orderTransactions', function ($query) {
                $query->where('status', 'success');
                $query->where('type', 'Credit');
                $query->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->startOfMonth()]);
            })
                ->where('member_id', $member->id)
                ->sum('grand_total');
    
            $sportsBill = SportsBilling::with('sportsBill')->whereHas('sportTransactions',function($query){
                $query->where('status', 'success');
                $query->where('type', 'Credit');
                $query->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->startOfMonth()]);
            })->where('membership_no',$member->membership_no)->get();
            
            $netPaySports = $sportsBill->sum(function ($item) {
                return $item->net_pay;
            });
    
            $total_bill = $total_bill + $netPaySports;
            $member->total_bill = $total_bill;
            $member->billing_month = $month;
        }

        return $members;
    }
}
