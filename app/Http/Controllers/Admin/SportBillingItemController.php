<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySportBillingItemRequest;
use App\Http\Requests\StoreSportBillingItemRequest;
use App\Http\Requests\UpdateSportBillingItemRequest;
use App\Models\SportBillingItem;
use App\Models\SportItemClass;
use App\Models\SportItemName;
use App\Models\SportItemType;
use App\Models\SportsBilling;
use App\Models\SportsDivision;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SportBillingItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sport_billing_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportBillingItems = SportBillingItem::with(['billing_division', 'billing_item_type', 'billing_item_class', 'billing_item_name', 'billing_issue_item'])->get();

        return view('admin.sportBillingItems.index', compact('sportBillingItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('sport_billing_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billing_divisions = SportsDivision::pluck('division', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_item_types = SportItemType::pluck('item_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_item_classes = SportItemClass::pluck('item_class', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_item_names = SportItemName::pluck('item_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_issue_items = SportsBilling::pluck('member_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sportBillingItems.create', compact('billing_divisions', 'billing_issue_items', 'billing_item_classes', 'billing_item_names', 'billing_item_types'));
    }

    public function store(StoreSportBillingItemRequest $request)
    {
        $sportBillingItem = SportBillingItem::create($request->all());

        return redirect()->route('admin.sport-billing-items.index');
    }

    public function edit(SportBillingItem $sportBillingItem)
    {
        abort_if(Gate::denies('sport_billing_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billing_divisions = SportsDivision::pluck('division', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_item_types = SportItemType::pluck('item_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_item_classes = SportItemClass::pluck('item_class', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_item_names = SportItemName::pluck('item_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_issue_items = SportsBilling::pluck('member_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sportBillingItem->load('billing_division', 'billing_item_type', 'billing_item_class', 'billing_item_name', 'billing_issue_item');

        return view('admin.sportBillingItems.edit', compact('billing_divisions', 'billing_issue_items', 'billing_item_classes', 'billing_item_names', 'billing_item_types', 'sportBillingItem'));
    }

    public function update(UpdateSportBillingItemRequest $request, SportBillingItem $sportBillingItem)
    {
        $sportBillingItem->update($request->all());

        return redirect()->route('admin.sport-billing-items.index');
    }

    public function show(SportBillingItem $sportBillingItem)
    {
        abort_if(Gate::denies('sport_billing_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportBillingItem->load('billing_division', 'billing_item_type', 'billing_item_class', 'billing_item_name', 'billing_issue_item');

        return view('admin.sportBillingItems.show', compact('sportBillingItem'));
    }

    public function destroy(SportBillingItem $sportBillingItem)
    {
        abort_if(Gate::denies('sport_billing_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportBillingItem->delete();

        return back();
    }

    public function massDestroy(MassDestroySportBillingItemRequest $request)
    {
        $sportBillingItems = SportBillingItem::find(request('ids'));

        foreach ($sportBillingItems as $sportBillingItem) {
            $sportBillingItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
