<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentSummaryController extends Controller
{
    public function view_payment_summary_list(Request $request){

        abort_if(Gate::denies('access_payment_summary'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
                
                $from_date = $request->from_date;
                $to_date = $request->to_date;

                // Page Length
                $pageNumber = ( $request->start / $request->length )+1;
                $pageLength = $request->length;
                $skip       = ($pageNumber-1) * $pageLength;

                $membershipStatuses = [
                    Member::MEMBERSHIP_STATUS_SELECT['Active'],
                    Member::MEMBERSHIP_STATUS_SELECT['Cancelled'],
                    Member::MEMBERSHIP_STATUS_SELECT['Blocked'],
                    Member::MEMBERSHIP_STATUS_SELECT['Sleeping']
                ];

                $billing_section = [
                    'Card' => 'Card',
                    'Locker' => 'Locker',
                    'Others' => 'Others',
                    'Restaurant' => 'Restaurant',
                    'Snooker' => 'Snooker',
                    'Proshop' => 'Proshop',
                    'Practice' => 'Practice',
                    'GolfSimulator' => 'Golf Simulator',
                    'GolfLocker' => 'Golf Locker',
                    'GolfCourse' => 'Golf Course',
                    'GolfCartFee' => 'Golf Cart Fee',
                ];
                
                $members = Member::with(['membership_type','bills','latestBill','latestMonthlyBill','latestPayments'])->whereIn('membership_status',$membershipStatuses)->select(sprintf('%s.*', (new Member)->table));

                $recordsFiltered = $recordsTotal = $members->count();

                $members = $members->skip($skip)->take($pageLength)->get();

                $table = Datatables::of($members);

                // $table->addColumn('actions', '&nbsp;');

                // $table->editColumn('latest_monthly_bill.billing_amount', function ($row) {
                //     return $row->latest_monthly_bill ? $row->latest_monthly_bill->billing_amount : 'N/A';
                // });

                // $table->editColumn('membership_type.name', function ($row) {
                //     return $row->membership_type ? $row->membership_type->name : '';
                // });

                // $table->editColumn('latestBill.total', function ($row) {
                //     return $row->latestBill ? $row->latestBill->total : '';
                // });

                // $table->rawColumns(['actions']);


                return response()->json(
                    [
                    "draw"=> $request->draw, 
                    "recordsTotal"=> $recordsTotal, 
                    "recordsFiltered" => $recordsFiltered, 
                    'data' => $members
                ], 200);
        }

        return view('admin.paymentSummary.index');
    }
}
