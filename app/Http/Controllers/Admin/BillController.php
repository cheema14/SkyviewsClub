<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CalculateBills;
use App\Models\Bill;
use App\Models\Member;
use App\Models\Order;
use App\Models\SportsBilling;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
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
                
            $total_bill = 0;
            $posted_month = $request->month;

            // Page Length
            $pageNumber = ( $request->start / $request->length )+1;
            $pageLength = $request->length;
            $skip       = ($pageNumber-1) * $pageLength;
            
            if($posted_month){
                $required_month  = Carbon::createFromDate(date('Y'), $posted_month, 1)->subMonth()->month;
                $invoiceDueDate = $request->invoiceDueDate;
            }
            
            $members = Member::where('membership_status',Member::MEMBERSHIP_STATUS_SELECT['Active'])->select(sprintf('%s.*', (new Member)->table));
            

            $member_bill_data = array();

            
            $recordsFiltered = $recordsTotal = $members->count();

            $members = $members->skip($skip)->take($pageLength)->get();
            
            foreach($members as $key=>&$member){
                
                $previousMonthStartDate = Carbon::createFromFormat('d-M-Y', $request->invoiceDueDate)->subMonth()->startOfMonth();
                $previousMonthEndDate = Carbon::createFromFormat('d-M-Y', $request->invoiceDueDate)->subMonth()->endOfMonth();


                $total_bill = Order::whereHas('orderTransactions', function ($query) {
                    $query->where('status', 'success');
                    $query->where('type', 'Credit');
                    $query->whereBetween('created_at', [Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->startOfMonth(),Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->endOfMonth()]);
                })
                    ->where('member_id', $member->id)
                    ->sum('grand_total');
                
                $sportsBill = SportsBilling::with('sportsBill')->whereHas('sportTransactions',function($query){
                    $query->where('status', 'success');
                    $query->where('type', 'Credit');
                    $query->whereBetween('created_at', [Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->startOfMonth(),Carbon::createFromFormat('d-M-Y', request('invoiceDueDate'))->subMonth()->endOfMonth()]);
                })->where('membership_no',$member->membership_no)->get();
               

                $netPaySports = $sportsBill->sum(function ($item) {
                    return $item->net_pay;
                });
        
                $total_bill = $total_bill + $netPaySports;
                $member->total_bill = $total_bill;
                $member->billing_month = Carbon::createFromFormat('d-M-Y', $invoiceDueDate)->format('F Y');
                $member->due_date = $invoiceDueDate;
                $member->invoice_status = 'Unpaid';
                $member->restaurant_charges = $total_bill;
                $member->sportsBill = $netPaySports;
                
            
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
                $member_bill_data['balance_bfcr'] = $member->arrears;
                $member_bill_data['monthly_subscription'] = $member->membership_type ? ($member->membership_type->monthly_fee - 100) : '100';
                $member_bill_data['caddies_fee'] = 100;
                $member_bill_data['restaurant_fee'] = $member->restaurant_charges;
                $member_bill_data['sports_bill'] = $member->sportsBill;
                $member_bill_data['total'] = $member->restaurant_charges + $member->sportsBill + $member->membership_type?->monthly_fee;
                if($bill_check?->net_balance_payable){
                    $member_bill_data['net_balance_payable'] = $bill_check->net_balance_payable;
                }
                else{
                    $member_bill_data['net_balance_payable'] = $member->restaurant_charges + $member->sportsBill + $member->membership_type?->monthly_fee;
                }
                $member_bill_data['bill_month'] = Carbon::createFromFormat('d-M-Y', $request->invoiceDueDate)->format('Y-m-d');
                $member_bill_data['status'] = Bill::BILL_STATUS['Unpaid'];
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
            }
            
            $table = Datatables::of($members);

            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {

                $viewGate = 'order_show';
                $printGate = 'order_show';
                $crudRoutePart = 'monthlyBilling';

                return view('admin.monthlyBills.datatablesActions', compact(
                    'viewGate',
                    'printGate',
                    'crudRoutePart',
                    'row'
                ));
            });

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

            return $table->make(true);
        }
        

        return view('admin.monthlyBills.due_bills');
    }

    public function view_due_bill($id){
        
        abort_if(Gate::denies('view_due_bill'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $member = Member::find($id);
        // dd('ok',$member);
        $member = $member->load('latestBill','membership_type');
        $pdf = PDF::loadView('admin.bills.monthly_bill_generation', ['member' => $member->load('latestBill'), 'bill' => $member->latestBill->restaurant_fee, 'sportsBill' => $member->latestBill->sports_bill, 'arrears' => $member->arrears]);

        return $pdf->setOption('dpi', 100)
            ->setOption('encoding', 'ASCII-85')->setOption('disable-smart-shrinking', true)->setOption('enable-local-file-access', true)->inline('invoice.pdf');

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
