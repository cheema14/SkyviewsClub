<?php

namespace App\Http\Controllers\Admin;

use App\Events\UpdateMemberArrearEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyBillRequest;
use App\Http\Requests\UpdateMonthlyBillRequest;
use App\Models\Bill;
use App\Models\Member;
use App\Models\MonthlyBill;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBills = MonthlyBill::all();

        return view('admin.monthlyBills.index', compact('monthlyBills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('monthly_bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyBills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonthlyBillRequest $request)
    {
        $monthlyBill = MonthlyBill::create($request->all());

        // As the monthly arrear (bill) is changed so lets 
        // fire an event which will update the bill. 
        // Case ---

        // Case is that the amount of monthly arrear will always be of current month. 
        // Secondly, we will find monthly_bill with current month which means if
        // we are in September then the bill_month will have september date BUT
        // the bill is of August.

        UpdateMemberArrearEvent::dispatch($monthlyBill);

        return redirect()->route('admin.monthly-bills.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyBills.show', compact('monthlyBill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyBills.edit', compact('monthlyBill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMonthlyBillRequest $request, MonthlyBill $monthlyBill)
    {
        if($request->billing_amount < $monthlyBill->billing_amount){
            return back()->with('billing_amount', 'Billing amount cannot be less than saved amount.');;
        }
        
        // Find the corresponding bill against this member
        $member_id = Member::select('id')->where('membership_no',$request->membership_no)->first();
        
        
        // $lastMonthStart = Carbon::now()->subMonth(2)->startOfMonth();
        // $lastMonthEnd = Carbon::now()->subMonth(2)->endOfMonth();

        
        // $bills = Bill::where('status','!=',Bill::BILL_STATUS['Paid'])
        // ->where('member_id',$member_id->member_id)
        // ->whereBetween('bill_month',[$lastMonthStart,$lastMonthEnd])
        // ->get();
        
        
        // if( !$bills->isEmpty()){
        //     // If bill exists then update the arrears column
        //     $bills->balance_bfcr += $request->billing_amount;
        // }

        $update_call = true;

        $monthlyBill->update($request->all());
        UpdateMemberArrearEvent::dispatch($monthlyBill,$update_call);

        return redirect()->route('admin.monthly-bills.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBill->delete();

        return back();
    }

    public function massDestroy(MassDestroyMonthlyBillRequest $request)
    {
        $monthlyBills = MonthlyBill::find(request('ids'));

        foreach ($monthlyBills as $monthlyBill) {
            $monthlyBill->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
