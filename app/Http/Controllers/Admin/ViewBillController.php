<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Order;
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

        $sportsTotal = $member->load('sportsBill');
        // dd($sportsTotal);

        $pdf = PDF::loadView('admin.bills.monthly_bill_pdf', ['member' => $member->load('latestBill'), 'bill' => $sum, 'sportsBill' => $sportsTotal?->sportsBill->net_pay]);

        return $pdf->setOption('dpi', 100)
            ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');
    }

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
