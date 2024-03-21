<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePaymentReceiptRequest;
use App\Models\Bill;
use App\Models\Member;
use App\Models\PaymentReceipt;
use Gate;
use Illuminate\Http\Request;
use PDF;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentReceiptController extends Controller
{

    use MediaUploadingTrait;

    public function create_bill_receipt(Request $request,$id){
        
        abort_if(Gate::denies('create_bill_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $member = Member::find($id);
        $billDetails = $member->load('latestBill');
        
        $receiptNo = PaymentReceipt::latest()->first();
       
        
        if($receiptNo){
            $receiptNo = $receiptNo->id;
        }

        return view('admin.monthlyBills.receipts.create', compact('billDetails','receiptNo'));
    }

    public function store_bill_receipt(StorePaymentReceiptRequest $request){
        
        abort_if(Gate::denies('create_bill_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        // dd($request->all());
        $invoiceNumber = $request->invoice_number;
        $matches = [];

        if (preg_match('/\d+/', $invoiceNumber, $matches)) {
            $integerPart = (int)$matches[0];   
        }

        $bill = Bill::find($integerPart);
        $billingId = $bill->id;
        $member_id = $bill->member_id;
        
        $receipt = PaymentReceipt::create([
            'receipt_no' => $request->receipt_no,
            'receipt_date' => $request->receipt_date,
            'bill_type' => $request->bill_type,
            'billing_month' => $request->billing_month,
            'invoice_number' => $request->invoice_number,
            'invoice_amount' => $request->invoice_amount,
            'pay_mode' => $request->pay_mode,
            'received_amount' => $request->received_amount,
            'cheque_number' => $request->cheque_number,
            'bank_name' => $request->bank_name,
            'cheque_date' => $request->cheque_date ? $request->cheque_date : '',
            'deposit_slip_number' => $request->deposit_slip_number,
            'deposit_bank_name' => $request->deposit_bank_name,
            'deposit_date' => $request->deposit_date ? $request->deposit_date : '',
            'user_id' => auth()->user()->id,
            'bill_id' => $billingId,
            'member_id' => $member_id,
        ]);

        // Now Find the member and update its arrears
        $member = Member::find($bill->member_id);


        // Now update the billing amount
        
        $bill->net_balance_payable = $bill->net_balance_payable - $request->received_amount;
        $arrears = $member->arrears;
        if($bill->net_balance_payable <= 0){
            $bill->status = Bill::BILL_STATUS['Paid'];
            $arrears += $bill->net_balance_payable;
        }
        else{
            $bill->status = Bill::BILL_STATUS['Partial'];
            $arrears += $bill->net_balance_payable;
        }

        $member->arrears = $arrears;
        $bill->save();
        $member->save();


        if ($request->input('cheque_photo', false)) {
            $receipt->addMedia(storage_path('tmp/uploads/'.basename($request->input('cheque_photo'))))->toMediaCollection('cheque_photo');
        }
        
        if ($request->input('deposit_photo', false)) {
            $receipt->addMedia(storage_path('tmp/uploads/'.basename($request->input('deposit_photo'))))->toMediaCollection('cheque_photo');
        }

        return redirect()->route('admin.monthlyBilling.get-all-receipts');
    }

    public function get_all_receipts(Request $request){

        abort_if(Gate::denies('paid_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if ($request->ajax()) {

            $query = PaymentReceipt::with(['member', 'bill'])->select(sprintf('%s.*', (new PaymentReceipt)->table));
            $table = Datatables::of($query);

            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                
                $viewGate = 'view_payment_receipt';
                $downLoadGate = 'download_payment_receipt';

                // the second route parameter - like admin.monthlyBilling.<method>
                $crudRoutePart = 'monthlyBilling';

                return view('admin.monthlyBills.receipts.partials.datatablesActions', compact(
                    'viewGate',
                    'downLoadGate',
                    'crudRoutePart',
                    'row'
                ));
            });


            $table->rawColumns(['actions']);

            return $table->make(true);
            
        }

        return view('admin.monthlyBills.receipts.index');
    }

    public function view_payment_receipt(Request $request){
        
        abort_if(Gate::denies('view_payment_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        echo 'view_payment_receipt';
    }

    public function download_payment_receipt(Request $request){
        
        abort_if(Gate::denies('download_payment_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // dd($request->all());
        $id = $request->id;

        $receipt = PaymentReceipt::find($id);
        $member = $receipt->load('member.latestBill');

        // Fetch all bills like 1 restaurant, 2 sports etc 
        $restaurant_bill = $receipt->bill->restaurant_fee;
        $sports_bill = $receipt->bill->sports_bill;
        $arrears = $receipt->member->arrears;

        $total_payable = $restaurant_bill + $sports_bill + $arrears;
        $amount_received = $receipt->received_amount;
        $receipt->member->arrears =  $total_payable - $amount_received;
    
        return view('admin.monthlyBills.receipts.showReceipt',
            [
                'receipt'=>$receipt,'member' => $receipt->member, 
                'arrears' => $receipt->member->arrears,
                'bill' => $receipt->bill->restaurant_fee, 
                'sportsBill' => $receipt->bill->sports_bill, 
                'arrears' => $receipt->member->arrears
            ]
        ); 
        // $pdf = PDF::loadView('admin.monthlyBills.receipts.showReceipt', ['member' => $member, 'bill' => $member->latestBill?->restaurant_fee, 'sportsBill' => $member->latestBill?->sports_bill, 'arrears' => $member->arrears]);
        
        // return $pdf->setOption('dpi', 100)
        //     ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');
        
    }
}
