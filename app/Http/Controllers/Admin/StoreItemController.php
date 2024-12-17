<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStoreItemRequest;
use App\Http\Requests\StoreStoreItemRequest;
use App\Http\Requests\UpdateStoreItemRequest;
use App\Models\ItemClass;
use App\Models\ItemType;
use App\Models\Store;
use App\Models\StoreItem;
use App\Models\Unit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('store_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $storeItems = StoreItem::with(['store', 'item', 'item_class', 'unit'])->get();

        return view('admin.storeItems.index', compact('storeItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('store_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stores = Store::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $items = ItemType::pluck('type', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $item_classes = ItemClass::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        return view('admin.storeItems.create', compact('item_classes', 'items', 'stores', 'units'));
    }

    public function store(StoreStoreItemRequest $request)
    {
        $storeItem = StoreItem::create($request->all());

        return redirect()->route('admin.store-items.index')->with('created', 'New Store Item Added.');
    }

    public function edit(StoreItem $storeItem)
    {
        abort_if(Gate::denies('store_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stores = Store::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $items = ItemType::pluck('type', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $item_classes = ItemClass::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $storeItem->load('store', 'item', 'item_class', 'unit');

        return view('admin.storeItems.edit', compact('item_classes', 'items', 'storeItem', 'stores', 'units'));
    }

    public function update(UpdateStoreItemRequest $request, StoreItem $storeItem)
    {
        $storeItem->update($request->all());

        return redirect()->route('admin.store-items.index')->with('updated', 'Store Item Updated.');
    }

    public function destroy(StoreItem $storeItem)
    {
        abort_if(Gate::denies('store_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $storeItem->delete();

        return back()->with('deleted', 'Store Item Deleted.');
    }

    public function massDestroy(MassDestroyStoreItemRequest $request)
    {
        $storeItems = StoreItem::find(request('ids'));

        foreach ($storeItems as $storeItem) {
            $storeItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function get_by_id(Request $request)
    {

        abort_if(Gate::denies('store_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (! $request->item_id) {
            $data = 'Not Item Found!';
        } else {
            $data = StoreItem::with('gr_item')->find($request->item_id);
        }

        return response()->json(['unit' => $data->unit,'quantity'=>$data->gr_item?->quantity]);
    }
}
