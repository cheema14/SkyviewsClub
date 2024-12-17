<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PaymentReceipt;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentHistoryController extends Controller
{
    public function index(Request $request){
        
        abort_if(Gate::denies('access_payment_history'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // echo 'payment history';

        if ($request->ajax()) {

            $query = PaymentReceipt::with(['member', 'bill'])
                        ->select(
                            'members.id as member_id',
                            'members.name as member_name',
                            'members.membership_no',
                            'members.husband_father_name',
                            'members.cnic_no',
                            'members.membership_status',
                            'members.arrears',
                            'payment_receipts.billing_month',
                            'payment_receipts.invoice_amount',
                            DB::raw('SUM(payment_receipts.received_amount) as totalPaid')
                        )
                        ->leftJoin('members', 'members.id', '=', 'payment_receipts.member_id')
                        ->groupBy(
                            'members.id',
                            'members.name',
                            'members.membership_no',
                            'members.husband_father_name',
                            'members.cnic_no',
                            'members.membership_status',
                            'members.arrears',
                            'payment_receipts.billing_month',
                            'payment_receipts.invoice_amount'
                        )
                        ->orderBy('members.id');
                        // ->orderBy('payment_receipts.created_at', 'desc');

            
            $table = Datatables::of($query);

            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $billingMonth = str_replace(' ', '-', $row->billing_month);
                return '<a class="btn btn-success" target="_blank" href="'.route("admin.paymentHistory.view-member-payment-history",['billing_month' => $row->billing_month,'member_id'=>$row->member_id]).'"><i style="margin-right:10px; " class="fa fa-edit fa-lg"></i>View History</a>';
            });

            // $table->editColumn('actions', function ($row) {
            //     // dd($row);
            //     if (!empty($row->billing_month)) {
            //         $billingMonth = urlencode($row->billing_month); // URL encode the billing month
            //         return '<a class="btn btn-success" target="_blank" href="'.route("admin.paymentHistory.view-member-payment-history", ['billing_month' => $billingMonth, 'member_id' => $row->member_id]).'">
            //                 <i style="margin-right:10px;" class="fa fa-edit fa-lg"></i>View History</a>';
            //     } else {
            //         // Handle when billing_month is null or empty, either by disabling the link or showing a message
            //         return '<button class="btn btn-secondary" disabled><i style="margin-right:10px;" class="fa fa-ban fa-lg"></i>No History Available</button>';
            //     }
            // });


            $table->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.monthlyBills.paymentHistory.index');
    }

    public function view_member_payment_history(Request $request,$billingMonth,$member_id){
        
        $billingMonth = str_replace('-',' ',$billingMonth);
        $paymentHistory = PaymentReceipt::with('member')
                            ->where('billing_month',$billingMonth)->get();
        $memberData = collect($paymentHistory->pluck('member')->first());
        
        return view('admin.monthlyBills.paymentHistory.show',compact('paymentHistory','memberData'));
    }
}
