<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyItemTypeRequest;
use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use App\Models\ItemType;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ItemTypeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('item_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itemTypes = ItemType::all();

        return view('admin.itemTypes.index', compact('itemTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('item_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.itemTypes.create');
    }

    public function store(StoreItemTypeRequest $request)
    {
        $itemType = ItemType::create($request->all());

        return redirect()->route('admin.item-types.index')->with('created', 'New Item Type Added.');
    }

    public function edit(ItemType $itemType)
    {
        abort_if(Gate::denies('item_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.itemTypes.edit', compact('itemType'));
    }

    public function update(UpdateItemTypeRequest $request, ItemType $itemType)
    {
        $itemType->update($request->all());

        return redirect()->route('admin.item-types.index')->with('updated', 'Item Type Updated.');
    }

    public function destroy(ItemType $itemType)
    {
        abort_if(Gate::denies('item_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itemType->delete();

        return back()->with('deleted', 'Item Type Deleted.');
    }

    public function massDestroy(MassDestroyItemTypeRequest $request)
    {
        $itemTypes = ItemType::find(request('ids'));

        foreach ($itemTypes as $itemType) {
            $itemType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
