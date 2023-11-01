<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySportsBillingRequest;
use App\Http\Requests\StoreSportsBillingRequest;
use App\Http\Requests\UpdateSportsBillingRequest;
use App\Models\SportItemClass;
use App\Models\SportItemName;
use App\Models\SportItemType;
use App\Models\SportsBilling;
use App\Models\SportsDivision;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SportsBillingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sports_billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportsBillings = SportsBilling::all();

        return view('admin.sportsBillings.index', compact('sportsBillings'));
    }

    public function create()
    {
        abort_if(Gate::denies('sports_billing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $divisions = SportsDivision::pluck('division', 'id')->prepend(trans('global.pleaseSelect'), '');

        $new_billing_id = SportsBilling::latest()->value('id');

        $new_billing_id = $new_billing_id + 1;

        return view('admin.sportsBillings.create', compact('divisions', 'new_billing_id'));
    }

    public function store(StoreSportsBillingRequest $request)
    {
        // dd($request->all());
        $billingIssue = SportsBilling::create($request->all());

        foreach ($request->items as $key => $value) {

            $billingIssue->sportBillingSportBillingItems()->create([
                'billing_division_id' => $value['billing_division_id'],
                'billing_item_type_id' => $value['billing_item_type_id'],
                'billing_item_class_id' => $value['billing_item_class_id'],
                'billing_item_name_id' => $value['billing_item_name_id'],
                'billing_item_description' => $value['billing_item_description'],
                'quantity' => $value['quantity'],
                'rate' => $value['rate'],
                'amount' => $value['amount'],
            ]);
        }

        return redirect()->route('admin.sports-billings.index');
    }

    public function edit(SportsBilling $sportsBilling)
    {
        abort_if(Gate::denies('sports_billing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportsBilling->load('sportBillingSportBillingItems.billing_issue_item');
        // dd($sportsBilling);

        return view('admin.sportsBillings.edit', compact('sportsBilling'));
    }

    public function update(UpdateSportsBillingRequest $request, SportsBilling $sportsBilling)
    {
        $sportsBilling->update($request->all());

        return redirect()->route('admin.sports-billings.index');
    }

    public function show(SportsBilling $sportsBilling)
    {
        abort_if(Gate::denies('sports_billing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sportsBillings.show', compact('sportsBilling'));
    }

    public function destroy(SportsBilling $sportsBilling)
    {
        abort_if(Gate::denies('sports_billing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportsBilling->delete();

        return back();
    }

    public function massDestroy(MassDestroySportsBillingRequest $request)
    {
        $sportsBillings = SportsBilling::find(request('ids'));

        foreach ($sportsBillings as $sportsBilling) {
            $sportsBilling->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    // Fetch relevant sports divisions, item types, item classes and item names for create form

    public function get_sports_item_type(Request $request)
    {
        abort_if(Gate::denies('sports_billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = [];
        if (! $request->division_id) {
            $data = 'Not Item Found!';
        } else {
            $data = SportsDivision::with('sportItemTypes')->where('id', '=', $request->division_id)->get()->first();
        }
        // dd($data->sportItemTypes);
        return response()->json(['itemType' => $data]);
    }

    public function get_sports_classes(Request $request)
    {
        abort_if(Gate::denies('sports_billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [];

        if (! $request->item_type) {
            $data = 'Not Item Found!';
        } else {
            $data = SportItemType::with('sportItemClasses')->where('id', '=', $request->item_type)->get()->first();
        }

        return response()->json(['itemClasses' => $data]);
    }

    public function get_sports_items(Request $request)
    {
        abort_if(Gate::denies('sports_billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [];

        if (! $request->item_class) {
            $data = 'Not Item Found!';
        } else {
            $data = SportItemClass::with('sportItems')->where('id', '=', $request->item_class)->get()->first();
        }

        return response()->json(['itemNames' => $data]);
    }

    public function get_item_details(Request $request)
    {
        abort_if(Gate::denies('sports_billing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [];
        if (! $request->item_id) {
            $data = 'Not Item Found!';
        } else {
            $data = SportItemName::find($request->item_id);
        }

        return response()->json(['itemDetails' => $data]);
    }

    public function print_sports_bill(SportsBilling $sportsBilling)
    {
        $data = $sportsBilling->load('sportBillingSportBillingItems', 'sportBillingSportBillingItems.billing_item_name');

        $gross_total = $data->gross_total;
        $total_payable = $data->total_payable;
        $net_payable = $data->net_pay;

        return view('admin.sportsBillings.print_sports_bill', compact('data', 'gross_total', 'total_payable', 'net_payable'));

    }
}
