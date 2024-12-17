<?php

/** 
 * Class: ViewBillController 
 * Purpose: i- Generates monthly and displays a PDF
 * ii- Also contains a test function to use mike42/escpos package 
 */ 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Order;
use App\Models\SportItemClass;
use App\Models\SportsBilling;
use App\Printing\ReceiptPrinter;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;

class ViewBillController extends Controller
{
    public function index(Member $member)
    {
        $month = Carbon::now()->subMonth()->month;

        $restaurant_sum = Order::whereHas('orderTransactions', function ($query) use ($month) {
            $query->where('status', 'success');
            $query->where('type', 'Credit');
            $query->whereMonth('created_at', $month);
        })
            ->where('member_id', $member->id)
            ->whereMonth('created_at',$month)
            ->sum('grand_total');
        
        // $sportsBill = SportsBilling::with('sportsBill','sportBillingSportBillingItems')->whereHas('sportTransactions',function($query){
        //     $query->where('status', 'success');
        //     $query->where('type', 'Credit');
        // })
        //     ->where('membership_no',$member->membership_no)
        //     ->whereMonth('bill_date',Carbon::now()->subMonth()->month)
        //     ->get();
        
            

            $sportsBill = SportsBilling::with(['sportsBill', 'sportBillingSportBillingItems' => function ($query) use ($month) {
                // $query->whereMonth('bill_date', $month);
            }])
            ->whereHas('sportTransactions', function ($query) use ($month) {
                $query->where('status', 'success')
                    ->where('type', 'Credit')
                    ->whereMonth('created_at',$month);
            })
            ->where('membership_no', $member->membership_no)
            ->whereMonth('bill_date', $month)
            ->get();
        
        
        $netPaySports = $sportsBill->sum(function ($item) {
            return $item->net_pay;
        });
        
        $sportsClasses = array();
        
        foreach($sportsBill as $k=>$sBill){
            $sportsItemDetails = $sBill->sportBillingSportBillingItems->load('billing_item_class');
            foreach($sportsItemDetails as $key=>$value){
                $sportsClasses[] = ['item_class' => $value->billing_item_class->item_class,'amount'=>$value->amount];    
            }
        }
        // dd($sportsClasses);
        // $sportsTotal = $member->load('sportsBill');

        // if (isset($sportsTotal->sportsBill)) {
        //     $net_pay = $sportsTotal->sportsBill->net_pay;
        // } else {
        //     $net_pay = 0;
        // }

        // Fet the credit this month i-e The amount a member has paid as 
        // payment receipt

        
        
        $pdf = PDF::loadView('admin.bills.monthly_bill_pdf', 
                            [
                            'member' => $member->load('latestBill'), 
                            'restaurantBill' => $restaurant_sum, 
                            'sportsBill' => $netPaySports, 
                            'arrears' => $member->previous_paid_arrears ,
                            'sportsItemsBill' => $sportsClasses,
                            'currentMonthCredit' => $member->payments->first(),
                            ]
                        );
        
                        // dd($sportsBill->first()->sportBillingSportBillingItems);
        return $pdf->setOption('dpi', 100)
            ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');
    }

    /* 
        This method is created to test mike42/escpos printer package
    */
    public function print_receipt()
    {

        $content = "Your receipt content goes here.\n";

        // $htmlContent = return view('');

        $htmlContent = strip_tags($htmlContent);

        $printer = new ReceiptPrinter();
        $printer->printReceipt($htmlContent);
        // dd($printer);
        return response()->json(['message' => 'Receipt printed successfully']);

    }
}
