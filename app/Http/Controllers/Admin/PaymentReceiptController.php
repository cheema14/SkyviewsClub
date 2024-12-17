<?php

namespace App\Http\Controllers\Admin;

use App\Events\UpdateMemberBillEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\PaymentReceiptCalculationTrait;
use App\Http\Requests\StoreMemberArrearRequest;
use App\Http\Requests\StorePaymentReceiptRequest;
use App\Models\Bill;
use App\Models\Member;
use App\Models\PaymentReceipt;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentReceiptController extends Controller
{

    use MediaUploadingTrait,PaymentReceiptCalculationTrait;

    public function create_bill_receipt(Request $request,$id){
        
        abort_if(Gate::denies('create_bill_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $member = Member::find($id);
        $billDetails = $member->load('latestBill');
        

        if($billDetails->latestBill?->status == Bill::BILL_STATUS['Paid']){
            return redirect()->route('admin.monthlyBilling.get-due-bills')->with('billPaid','Bill has already been paid for this member. Cannot create receipt for it.');
        }
        $receiptNo = PaymentReceipt::latest()->first();
        
        $payment_receipts_bill_types = PaymentReceipt::where('member_id', '=', $member->id)
            ->whereMonth('receipt_date', Carbon::now()->month)
            ->whereIn('billing_section', ['Card', 'Locker', 'Others'])
            ->first();
        
        if($receiptNo){
            $receiptNo = $receiptNo->id;
        }
        
        $arrear_message = '';

        if($billDetails->arrears > 0){
            $arrear_message = 'This amount is due on the member.';
            $color = 'grey';
        }
        elseif($billDetails->arrears < 0){
            $arrear_message = 'The amount is paid in advance.';
            $color = 'red';
        }
        else{
            $arrear_message = 'No arrear.';
            $color = 'black';
        }
       
        return view('admin.monthlyBills.receipts.create', compact('billDetails','receiptNo','arrear_message','color','payment_receipts_bill_types'));
    }

    public function store_bill_receipt(StorePaymentReceiptRequest $request){
        
        abort_if(Gate::denies('create_bill_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // total_payable field has value of arrears in it. 
        $invoiceNumber = $request->invoice_number;
        $matches = [];
        $bill = '';
        $member_id = '';
        $arrears  = 0;
        
        if (preg_match('/\d+/', $invoiceNumber, $matches)) {
            $integerPart = (int)$matches[0];   
        }
        $bill = Bill::find($request->bill_id);

        if($request->bill_id){
            $bill = Bill::find($request->bill_id);
            $member_id = $bill->member_id;
        }
        $member = Member::where('id',$member_id)->get()->first();
        
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
            'bill_id' => $bill ? $bill->id: '',
            'member_id' => $member_id ? $member_id :'',
        ]);

        
        
        $this->calculate_bill_as_received_payment($bill,$member,$request->received_amount);

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
        

        $payment_receipt = PaymentReceipt::with('member','bill')->where('id',$request->id)->get()->first();
        $prepared_by = auth()->user()->name ?? 'Sports Admin';
        // dd($payment_receipt);
        
        return view('admin.monthlyBills.receipts.prints.payment_receipt', compact('payment_receipt','prepared_by'));
    }

    public function download_payment_receipt(Request $request){
        
        abort_if(Gate::denies('download_payment_receipt'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // dd($request->all());
        $id = $request->id;

        $receipt = PaymentReceipt::find($id);
        $member = $receipt->load('member.latestBill');

        // Fetch all bills like 1 restaurant, 2 sports etc 
        $restaurant_bill = $receipt->bill?->restaurant_fee;
        $sports_bill = $receipt->bill?->sports_bill;
        $arrears = $receipt->member->arrears;

        $total_payable = $restaurant_bill + $sports_bill + $arrears;
        $amount_received = $receipt->received_amount;
        $receipt->member->arrears =  $total_payable - $amount_received;
    
        return view('admin.monthlyBills.receipts.showReceipt',
            [
                'receipt'=>$receipt,'member' => $receipt->member, 
                'arrears' => $receipt->member->arrears,
                'bill' => $receipt->bill?->restaurant_fee, 
                'sportsBill' => $receipt->bill?->sports_bill, 
                'arrears' => $receipt->member->arrears
            ]
        ); 
        // $pdf = PDF::loadView('admin.monthlyBills.receipts.showReceipt', ['member' => $member, 'bill' => $member->latestBill?->restaurant_fee, 'sportsBill' => $member->latestBill?->sports_bill, 'arrears' => $member->arrears]);
        
        // return $pdf->setOption('dpi', 100)
        //     ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');
        
    }

    public function create_advance_payment_receipt(){

        abort_if(Gate::denies('create_advance_payment'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $receiptNo = PaymentReceipt::latest()->first();
       
        
        if($receiptNo){
            $receiptNo = $receiptNo->id;
        }

        return view('admin.monthlyBills.receipts.advance_payment_receipt',compact('receiptNo'));
    }

    public function store_advance_payment(StoreMemberArrearRequest $request){

        abort_if(Gate::denies('create_advance_payment'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $member = Member::where('membership_no',$request->membership_no)->get()->first();
        
        if(! $member){
            return back()->with('memberNotFound','Member not found');    
        }

        $receipt = PaymentReceipt::create([
            'receipt_no' => $request->receipt_no,
            'receipt_date' => date('Y-m-d'),
            'pay_mode' => PaymentReceipt::PAY_MODE["Arrear"],
            'received_amount' => $request->received_amount, // its arrear amount
            'user_id' => auth()->user()->id,
            'member_id' => $member ? $member->id :'',
        ]);

        $member->arrears = $member->arrears + $request->received_amount;
        $member->save();
        
        // if($member->arrears < 0){
        //     // Member has amount which is due on PAF
        //     $member->arrears = $member->arrears - $request->received_amount;
        //     $member->save();
        // }
        // else{
        //     // Member has amount which is due on him
        //     $member->arrears = $member->arrears > $request->received_amount ? $member->arrears - $request->received_amount : $request->received_amount - $member->arrears;
        //     $member->save();
        // }
       
        return redirect()->route('admin.monthlyBilling.get-all-receipts');
    }

    public function create_billing_section_payment_receipt(){

        abort_if(Gate::denies('add_locker_fee_billing_section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $receiptNo = PaymentReceipt::latest()->first();
        
        $currentMonth = Carbon::now();
        $nextMonth = $currentMonth->copy()->addMonth();
        
        if($receiptNo){
            $receiptNo = $receiptNo->id;
        }

        return view('admin.monthlyBills.receipts.billing_section_payment_receipt',compact('receiptNo','currentMonth','nextMonth'));
    }

    public function store_billing_section_payment(Request $request){

        abort_if(Gate::denies('add_locker_fee_billing_section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $section_values = array_keys(PaymentReceipt::BILLING_SECTION) ;
        // dd($section_values);
        $validator = Validator::make($request->all(), [
            'membership_no' => 'required',
            'billing_section' => [
                'required',
                Rule::in(array_keys(PaymentReceipt::BILLING_SECTION)),
            ],
            'billing_section_other' => 'sometimes|required_if:billing_section,Others|string|nullable',
            'received_amount' => 'required|integer',
            'billing_month' => [
                'required',
                Rule::in([
                    Carbon::now()->format('Y-m'),  // Current month
                    Carbon::now()->addMonth()->format('Y-m')  // Previous month
                ]),
            ],
        ]);

        if ($validator->fails()) {
            return back()->with('errors',$validator->errors());
        }

        $member = Member::where('membership_no',$request->membership_no)->get()->first();
        
        if(! $member){
            return back()->with('memberNotFound','Member not found');    
        }
        
        
        $receipt = PaymentReceipt::create([
            'receipt_no' => $request->receipt_no,
            'receipt_date' => date('Y-m-d'),
            'billing_section_new' => $request->billing_section,
            'received_amount' => $request->received_amount,
            'billing_month' => $request->billing_month,
            'user_id' => auth()->user()->id,
            'member_id' => $member ? $member->id :'',
        ]);
        
        if(Carbon::createFromFormat('Y-m',$request->billing_month)->format('Y-m') == Carbon::now()->format('Y-m')){
            // Call the event to update member's bill
            UpdateMemberBillEvent::dispatch($receipt);
        }

        return redirect()->route('admin.monthlyBilling.get-all-receipts');
    }
}
