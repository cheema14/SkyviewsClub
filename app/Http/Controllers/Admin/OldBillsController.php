<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PDF;

class OldBillsController extends Controller
{

    public function load_old_bills(Request $request){

        abort_if(Gate::denies('due_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $query = Bill::with(['member'])->orderBy('created_at', 'desc');
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = Carbon::now()->subMonth()->endOfMonth();

        // Build the query to exclude bills from the current month and year
        $query = Bill::with(['member'])
            ->where(function ($query) use ($currentMonth, $currentYear, $startDate, $endDate) {
                // Exclude the current month's bills
                $query->where(function($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('bill_month', '<>', $currentMonth)
                          ->orWhereYear('bill_month', '<>', $currentYear);
                });

                // Include only the bills from the last three months
                $query->whereBetween('bill_month', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc');
    
            if (isset($request->billing_month)) {
                $dueDate = Carbon::createFromFormat('d-M-Y', $request->invoice_due_date)->subMonth()->startOfMonth();
                $query->whereMonth('bill_month',$dueDate);
            }
    
            // dd($request->all());
            if (isset($request->bill_status)) {
                $query->where('status', '=', $request->bill_status);
            }
    
            if (isset($request->membership_no)) {
                $query->where('member_id', '=', $request->membership_no);
            }
            // dd($query);
            $member_payments = $query->get();
            // dd($member_payments);
        
            // dd($restaurant_total,$room_booking_total,$sports_total);
            return view('admin.monthlyBills.old_bills',
                    compact('member_payments')
            );
    }

    public function view_old_bill($id,Request $request){
        
        abort_if(Gate::denies('view_due_bill'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        
        $bill = Bill::with('member')->where('id','=',$id)->where('bill_month',$request->bill_month)->get()->first();
        if(!$bill){
            return back()->with('deleted', 'Department Deleted.');
        }
        

        // Negative Arrears means member has give advance amount
        // positive arrears amount is due on member
        try{
                        $pdf = PDF::loadView('admin.bills.old_bill_generation', 
                            [
                            'member' => $bill->member, 
                            'bill' => $bill->restaurant_fee, 
                            'sportsBill' => $bill->sports_bill, 
                            'arrears' => $bill->balance_bfcr,
                            'currentMonthCredit' => 0,
                            // 'payment_receipts_bill_types' => $payment_receipts_bill_types,
                            ]);
        
                                $check_print = $pdf->setOption('dpi', 100)
                                ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');
                            }
                            catch(Exception $e){
                               
                                $check_print = $e;
                            }
        
                            return $check_print;
    }
}
