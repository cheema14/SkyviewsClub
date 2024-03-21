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
use App\Models\SportsBilling;
use App\Printing\ReceiptPrinter;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class ViewBillController extends Controller
{
    public function index(Member $member)
    {

        $sum = Order::whereHas('orderTransactions', function ($query) {
            $query->where('status', 'success');
            $query->where('type', 'Credit');
        })
            ->where('member_id', $member->id)
            ->sum('grand_total');
        
        $sportsBill = SportsBilling::with('sportsBill')->whereHas('sportTransactions',function($query){
            $query->where('status', 'success');
            $query->where('type', 'Credit');
        })->where('membership_no',$member->membership_no)->get();
        
        $netPaySports = $sportsBill->sum(function ($item) {
            return $item->net_pay;
        });

        
        // $sportsTotal = $member->load('sportsBill');

        // if (isset($sportsTotal->sportsBill)) {
        //     $net_pay = $sportsTotal->sportsBill->net_pay;
        // } else {
        //     $net_pay = 0;
        // }
        $pdf = PDF::loadView('admin.bills.monthly_bill_pdf', ['member' => $member->load('latestBill'), 'bill' => $sum, 'sportsBill' => $netPaySports, 'arrears' => $member->arrears]);

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
