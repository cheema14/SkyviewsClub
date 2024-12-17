<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CalculateBills;
use App\Models\Bill;
use App\Models\DiscountedMembershipFee;
use App\Models\Member;
use App\Models\MonthlyBill;
use App\Models\Order;
use App\Models\PaymentReceipt;
use App\Models\RoomBooking;
use App\Models\SportsBilling;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use PDF;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;

class BillController extends Controller
{
    use CalculateBills;
    
    public function index(){

        $members = Member::all();

        $data = $members->map(function($member){

            return  [
                'member_id' => $member->id,
                'monthly_subscription' => $member->membership_type->monthly_fee,
                'cafe_charges' => $member->creditOnlyTransactions,
                'bill_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

        })->toArray();

        // dd($data);
        // Find charges of restaurant or cafe
        // $where = [
        //     'type' => 'Credit',
        //     'status' => 'Success'
        //     ];
        // $transaction = Transaction::where(['type','=', 'Credit']);

        Bill::insert($data);


    }



    public function get_due_bills(Request $request){
        
        abort_if(Gate::denies('due_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if ($request->ajax()) {
                
            $restaurant_charges = $roomBookingExpenses = $total_bill = $payment_receipts_bill_types = $discount_percentage = 0;
            $posted_month = $request->month;
            $old_bill = false;

            // Page Length
            $pageNumber = ( $request->start / $request->length )+1;
            $pageLength = $request->length;
            $skip       = ($pageNumber-1) * $pageLength;
            
            if($posted_month){
                $required_month  = Carbon::createFromDate(date('Y'), $posted_month, 1)->subMonth()->month;
                $invoiceDueDate = $request->invoiceDueDate;
            }
            
            // Fetch previous months
            if($posted_month < Carbon::now()->month){
                
            }

            $membershipStatuses = [
                Member::MEMBERSHIP_STATUS_SELECT['Active'],
                Member::MEMBERSHIP_STATUS_SELECT['Cancelled'],
                Member::MEMBERSHIP_STATUS_SELECT['Blocked'],
                Member::MEMBERSHIP_STATUS_SELECT['Sleeping']
            ];
            
            $members = Member::whereIn('membership_status',$membershipStatuses)->select(sprintf('%s.*', (new Member)->table));
            
            // Search queries
            
            if ($request->has('search') && $request->search['value']) {
                
                $search = $request->search['value'];
                

                $members = $members->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('membership_no', 'LIKE', "%{$search}%");
                    // Add more fields as necessary
                });
                
            }

            $previousMonth = Carbon::now()->subMonth()->month;

            $member_bill_data = array();

            
            $recordsFiltered = $recordsTotal = $members->count();

            $members = $members->skip($skip)->take($pageLength)->get();
            

            foreach($members as $key=>&$member){
                
                $previousMonthStartDate = Carbon::createFromFormat('d-M-Y', $request->invoiceDueDate)->subMonth()->startOfMonth();
                $previousMonthEndDate = Carbon::createFromFormat('d-M-Y', $request->invoiceDueDate)->subMonth()->endOfMonth();

                // Restaurant charges only
                $restaurant_charges = Order::whereHas('orderTransactions', function ($query) use ($previousMonth) {
                    $query->where('status', 'Success');
                    $query->where('type', 'Credit');
                    // $query->whereBetween('created_at', [Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->startOfMonth(),Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->endOfMonth()]);
                    $query->whereMonth('created_at',$previousMonth);
                })
                    ->where('member_id', $member->id)
                    ->sum('grand_total');

                $sportsBill = SportsBilling::with('sportsBill')->whereHas('sportTransactions',function($query) use ($previousMonth){
                    $query->where('status', 'Success');
                    $query->where('type', 'Credit');
                    // $query->whereBetween('created_at', [Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->startOfMonth(),Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->endOfMonth()]);
                    $query->whereMonth('created_at',$previousMonth);
                })->where('membership_no',$member->membership_no)->get();
               
                
                $netPaySports = $sportsBill->sum(function ($item) {
                    return $item->net_pay;
                });

                
                foreach($member->lastMonthCreditOnlyBookingTransactions as $key=>$bookingTransaction){
                    $booking_id = $bookingTransaction->booking_id;
                    $roomBookingExpenses += RoomBooking::where('id',$booking_id)->where('room_bookings_member_id',$member->id)->first()->total_price;
                }

                // Calculate facility charges
                // where billing_section_new has the values
                // when billing_section_new is NULL then it 
                // means that the member has paid some amount
                $payment_receipts_bill_types = PaymentReceipt::where('member_id', '=', $member->id)
                    // ->whereBetween('created_at', [$previousMonthStartDate, $previousMonthEndDate])
                    ->where('billing_month', Carbon::now()->format('Y-m'))
                    ->whereIn('billing_section_new', array_keys(PaymentReceipt::BILLING_SECTION))
                    ->get();
                
                
                // Fill up the bill with the following details
                // so that the values can be displayed in the 
                // payment summary 

                /* 
                    Card - done
                    Locker - done
                    Others - done (`fee` column is used for it)
                    Restaurant - already has it
                    Snooker - Column not found
                    Proshop - Column not found
                    Practice - done
                    GolfSimulator - Column not found
                    GolfLocker - Column not found
                    GolfCourse - Column not found
                    GolfCartFee - Column not found

                    receieved_amount - by name looks like amount received
                    payment receipts was built before this change, so instead of a new table
                    the same table is being used with some new columns.
                    
                    So whenever billing_section_new has some value then it means
                    the member has to pay the amount inside amount_received.
                */

                $member_bill_data = [
                    'card_fee' => 0,
                    'practice_range_coaching_fee' => 0,
                    'cart_fee' => 0,
                    'locker_fee' => 0,
                    'fee' => 0,
                    'snooker_fee' => 0,
                    'proshop_fee' => 0,
                    'golf_simulator' => 0,
                    'golf_locker' => 0,
                    'golf_course' => 0,
                    'golf_cart_fee' => 0,
                    'gym_subscription_fee' => 0,
                    'swimming_subscription' => 0,
                    'tennis_charges' => 0,
                    'bill_board_charges' => 0,
                ];

                $billingSectionMap = [
                    PaymentReceipt::BILLING_SECTION['Card'] => 'card_fee',
                    PaymentReceipt::BILLING_SECTION['Practice'] => 'practice_range_coaching_fee',
                    PaymentReceipt::BILLING_SECTION['Locker'] => 'locker_fee',
                    PaymentReceipt::BILLING_SECTION['Others'] => 'fee',
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

                foreach ($payment_receipts_bill_types as $paymentReceipt) {
                    $billing_section_new = $paymentReceipt->billing_section_new;
                    
                    // Check if the billing_section_new exists in the mapping array
                    if (isset($billingSectionMap[$billing_section_new])) {
                        // Use the mapped key to assign the received_amount
                        $member_bill_data[$billingSectionMap[$billing_section_new]] += $paymentReceipt->received_amount;
                    }
                }
                
                // dd($member_bill_data);

                $facility_charges_total = $payment_receipts_bill_types->sum(function ($item) {
                    return $item->received_amount;
                });


                // Fetch the previous bill
                // You fetch the previous month's bill and the sequence will work

                $bill_statses = ['Unpaid','Stalled','Pending','Partial','Locked'];

                $previous_pending_bill = Bill::where('member_id',$member->id)
                                             ->whereIn('status',$bill_statses)
                                             ->whereMonth('bill_month',Carbon::now()->subMonth(1))
                                             ->get()->pluck('net_balance_payable')->first();

                // Fetch arrears from MonthlyBill model
                $monthly_arrears = MonthlyBill::where('membership_no','=',$member->membership_no)->get()->first();
                $member_bill_data['balance_bfcr'] = $monthly_arrears ? $monthly_arrears->billing_amount : 0;
                $member_bill_data['balance_bfcr'] += $previous_pending_bill;

                // Room Booking charges
                
                
                
                $member->room_booking_charges = $roomBookingExpenses;
                $member->restaurant_charges = $restaurant_charges;
                
                // Restaurant charges, sports billing total, arrears and facility charges
                $total_bill = $restaurant_charges + $netPaySports + $member_bill_data['balance_bfcr'] + $facility_charges_total + $roomBookingExpenses;
                
                $member->total_bill = $total_bill;
                $member->billing_month = Carbon::createFromFormat('d-M-Y', $invoiceDueDate)->format('F Y');
                $member->due_date = $invoiceDueDate;
                $member->invoice_status = 'Unpaid';
                $member->sportsBill = $netPaySports;
                
                // Find monthly subscription for those members
                // who are absentees and have specific subscription 
                // amount. 
                $absentees_membership_fee = 0;
                
                if($member->monthly_type == 'Absentees'){

                    $discounted_obj = DiscountedMembershipFee::where('member_id',$member->id)->where('is_active',1)->get()->first();
                    
                    // if($member->id == 4 || $member->membership_no == '2056'){
                    //     dd($discounted_obj);
                    // }
                    if($discounted_obj && $discounted_obj->no_of_months > 0){
                        $absentees_membership_fee = $discounted_obj->monthly_subscription_revised;
                        $discounted_obj->no_of_months = $discounted_obj->no_of_months - 1;
                        
                        // Also if this was the last month of revised membership fee then make it inactive too
                        // so that it does not apply in the next month
                        if($discounted_obj->no_of_months <=0){
                            $discounted_obj->is_active = 0;
                        } 
                        $discounted_obj->save();
                    }

                    
                }
                
                
                // Create records for Bill Model
                // One row for every member - 
                // Checks required
                // 1. Only one row for every member
                // 2. No future or past rows to be created or updated. Only current month
            
            
                
                
                // Check if the bill's net payable amount has been modified
                // if there is a receipt then the net payable should be that
                // not the sum of restaurant sports membership fees (these should be first time)

                $bill_check = Bill::where('member_id','=',$member->id)
                                     ->whereMonth('bill_month','=',$request->month)
                                     ->get()
                                     ->first();
            
                
                $member_bill_data['member_id'] = $member->id;
                
                
                if($absentees_membership_fee > 0 ){
                    $member_bill_data['monthly_subscription'] = $absentees_membership_fee;
                }
                else{
                    
                    // if($member->discount_on_membership_fee){
                    //   $discount_percentage = $member->discount_on_membership_fee ?? 0;  
                    // }

                    // $monthly_fee = $member->membership_type ? $member->membership_type->monthly_fee : 100;

                    // $discounted_fee = $monthly_fee * (1 - $discount_percentage / 100);

                    // $member_bill_data['monthly_subscription'] = $discounted_fee;
                    // $member_bill_data['monthly_subscription'] = $member->membership_type ? ($member->membership_type->monthly_fee - 100) : '100';
                    $member_bill_data['monthly_subscription'] = $member->monthly_subscription;
                }
                
                $member_bill_data['caddies_fee'] = 100;
                $member_bill_data['restaurant_fee'] = $member->restaurant_charges;
                $member_bill_data['sports_bill'] = $member->sportsBill;
                $member_bill_data['room_booking_charges'] = $roomBookingExpenses;
                
                
                
                if($bill_check?->net_balance_payable){
                    $member_bill_data['net_balance_payable'] = $bill_check->net_balance_payable;
                    $member_bill_data['total'] =  $bill_check->total;
                }
                else{
                    // This will work when the bill is 
                    // being generated for the first time
                    // While the above if will run when the bill exists and 
                    // it simply returns the total that is present in the row

                    $member_bill_data['total'] = $member->restaurant_charges + $member->sportsBill + $member_bill_data['monthly_subscription'] + $member_bill_data['balance_bfcr'] + $facility_charges_total + $roomBookingExpenses;
                    $member_bill_data['net_balance_payable'] = $member->restaurant_charges + $member->sportsBill + $member_bill_data['monthly_subscription'] + $member_bill_data['balance_bfcr'] + $facility_charges_total + $roomBookingExpenses;
                }
                $member_bill_data['bill_month'] = Carbon::createFromFormat('d-M-Y', $request->invoiceDueDate)->format('Y-m-d');
                
                if($member_bill_data['net_balance_payable'] > 0){
                    $member_bill_data['status'] = Bill::BILL_STATUS['Unpaid'];
                }
                else{
                    $member_bill_data['status'] = Bill::BILL_STATUS['Paid'];
                }
                
                $member_bill_data['user_id'] = auth()->user()->id;
                $member_bill_data['created_at'] = Carbon::now();
                $member_bill_data['updated_at'] = Carbon::now();
                
                $bill_exists = Bill::where('member_id','=',$member_bill_data['member_id'])
                                     ->whereMonth('bill_month','=',$request->month)
                                     ->get()
                                     ->first();
                
                if(is_null($bill_exists)){
                    $bill_id = Bill::updateOrCreate($member_bill_data);
                    $bill_id = $bill_id->id;   
                }
                else{
                    // Find relevant receipts against that bill
                    // if receipts found, then sum up the amounts and reflect in
                    // net payable

                    
                    $bill_id = Bill::where(['member_id' => $member_bill_data['member_id'], 'bill_month' => $member_bill_data['bill_month']])
                        ->update($member_bill_data);

                    $updatedRecord = Bill::where(['member_id' => $member_bill_data['member_id'], 'bill_month' => $member_bill_data['bill_month']])
                    ->first();
                    
                    if ($updatedRecord) {
                        $bill_id = $updatedRecord->id;
                    } else {
                        // Record not found, handle accordingly
                        //$bill_id = null;
                    }
                    
                }
                
                
                $member->total_bill = $member_bill_data['total'];
                $member->net_balance_payable = $member_bill_data['net_balance_payable'];
                $member->bill_id = $bill_id;
                $member->total_billing_amount = $member_bill_data['total'] + $member_bill_data['balance_bfcr'];
                $member->bill_status = $member_bill_data['status'];
                $roomBookingExpenses = 0;
            }   
            
            $table = Datatables::of($members);

            $table->addColumn('actions', '&nbsp;');
            // $table->editColumn('actions', function ($row) {

            //     $viewGate = 'order_show';
            //     $printGate = 'order_show';
            //     $crudRoutePart = 'monthlyBilling';

            //     return view('admin.monthlyBills.datatablesActions', compact(
            //         'viewGate',
            //         'printGate',
            //         'crudRoutePart',
            //         'row'
            //     ));
            // });

            

            $table->rawColumns(['actions']);
            
            foreach ($members as &$member) {
                // Render the actions HTML using the datatablesActions.blade.php view
                $actionsHtml = View::make('admin.monthlyBills.datatablesActions', [
                    'viewGate' => 'order_show',
                    'printGate' => 'order_show',
                    'crudRoutePart' => 'monthlyBilling',
                    'row' => $member,
                ])->render();
    
                // Add other data fields as needed
                $rowData = [
                    'id' => $member->id,
                    'name' => $member->name,
                    // ... add other fields
                    'actions' => $actionsHtml,
                ];
    
                $member->actions = $rowData;
            }


            return response()->json(
                [
                "draw"=> $request->draw, 
                "recordsTotal"=> $recordsTotal, 
                "recordsFiltered" => $recordsFiltered, 
                'data' => $members
            ], 200);

            // return $table->make(true);
        }
        

        return view('admin.monthlyBills.due_bills');
    }

    public function view_due_bill($id){
        
        abort_if(Gate::denies('view_due_bill'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $member = Member::find($id);
        $month = Carbon::now()->subMonth()->month;
        
        $member = $member->load('latestBill','membership_type','discountedMembershipFees');
        $discount_percentage = 0;
        
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

        $sportsClasses = array();
        
        foreach($sportsBill as $k=>$sBill){
            $sportsItemDetails = $sBill->sportBillingSportBillingItems->load('billing_item_class');
            foreach($sportsItemDetails as $key=>$value){
                $sportsClasses[] = ['item_class' => $value->billing_item_class->item_class,'amount'=>$value->amount];    
            }
        }

        // Card - Locker or Other fee

        // $payment_receipts_bill_types = PaymentReceipt::where('member_id', '=', $member->id)
        //     ->whereMonth('created_at', Carbon::now()->subMonth()->month)
        //     ->whereIn('billing_section_new', array_keys(PaymentReceipt::BILLING_SECTION))
        //     ->get();

        $payment_receipts_bill_types = PaymentReceipt::where('member_id', '=', $member->id)
            ->where('billing_month', Carbon::now()->format('Y-m'))
            ->whereIn('billing_section_new', array_keys(PaymentReceipt::BILLING_SECTION))
            ->select('billing_section_new', DB::raw('SUM(received_amount) as total_received_amount'))
            ->groupBy('billing_section_new')
            ->get();
        
        // Calculate the arrears 
        // Handle plus/minus of arrear field
        $arrears_display = 0;
        
        // Fetch only those payment receipts which have billing_section_new or billing_section(old clumn)
        //  as null - Because, billing_section has separate form and it is becomes an expense 
        // when billing_section_new has some value. 
        // So the below relation of payments with the member has that condition embedded in it.

        $totalPaidByMember = $member->payments?->whereNull('billing_section_new')->sum(function ($item) {
            return $item->received_amount;
        });

        if($member->discount_on_membership_fee){
            $discount_percentage = $member->discount_on_membership_fee ?? 0;  
        }

          $monthly_fee = $member->membership_type ? $member->membership_type->monthly_fee : 100;

          $discounted_fee = $monthly_fee * (1 - $discount_percentage / 100);

          $monthly_subscription = $discounted_fee;
        
          $advance_payment = $member->latestBill?->net_balance_payable - $totalPaidByMember;
          
          
        // Find if the member is absentees then display discountedmembership fee
        $absentee_monthly_subscription = 0;

        if($member->monthly_type == 'Absentees'){
            $absentee_monthly_subscription = $member->discountedMembershipFees?->monthly_subscription_revised;
        }
        // Negative Arrears means member has give advance amount
        // positive arrears amount is due on member
        try{
                        $pdf = PDF::loadView('admin.bills.monthly_bill_generation', 
                            [
                            'member' => $member->load('latestBill'), 
                            'bill' => $member->latestBill?->restaurant_fee, 
                            'sportsBill' => $member->latestBill?->sports_bill, 
                            'arrears' => $member->latestBill?->balance_bfcr,
                            // 'currentMonthCredit' => $member->payments->first(),
                            'currentMonthCredit' => $totalPaidByMember,
                            'sportsItemsBill' => $sportsClasses,
                            'payment_receipts_bill_types' => $payment_receipts_bill_types,
                            'monthly_subscription' => $monthly_subscription,
                            'advance_payment' => $monthly_subscription,
                            'absentee_monthly_subscription' => $absentee_monthly_subscription,
                            ]);
        
                                $check_print = $pdf->setOption('dpi', 100)
                                ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');
                            }
                            catch(Exception $e){
                               
                                $check_print = $e;
                            }
        
                            return $check_print;
    }

    public function print_all_bills_and_download(Request $request){

        abort_if(Gate::denies('view_due_bill'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $bill_month = Carbon::createFromFormat('d-M-Y', $request->billing_date)->format('Y-m-d');
        $all_bills = Bill::where('bill_month','=',$bill_month)->get();

        // Create a unique folder for storing PDFs
        $folderName = 'generated_pdfs_' .$bill_month;
    
        $path = storage_path('app/public/'.$folderName.'/');

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0755, true, true);
        }

        foreach($all_bills as $key=>$bill){
            

                $member = Member::find($bill->member_id);
                $member = $member->load('latestBill');
                
                        try {
                            $pdf = PDF::loadView('admin.bills.monthly_bill_generation', [
                                'member' => $member->load('latestBill'),
                                'bill' => $member->latestBill->restaurant_fee,
                                'sportsBill' => $member->latestBill->sports_bill,
                                'arrears' => $member->arrears,
                            ])
                                ->setOption('dpi', 100)
                                ->setOption('disable-smart-shrinking', true); 
                               
                                $pdf_name = 'invoice_'.$member->id.'.pdf';
                                $pdf->save($path.$pdf_name);
                
                
                        } catch (\Exception $e) {
                            // dd($e);
                            Log::info($e);  
                        }
                    
            
        } 

        
        $zipFileName = 'generated_pdfs.zip';
        $zip = new ZipArchive;
        $zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        
        foreach ($files as $name => $file)
        {
            
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);

            }
        }
        
        $zip->close();
        
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        return response()->json(['zipFileName' => $zipFileName]);
        

    }
    
    public function get_paid_bills(){
        dd("paid bills");
    }


}
