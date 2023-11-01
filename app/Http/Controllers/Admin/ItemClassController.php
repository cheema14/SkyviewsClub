<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyItemClassRequest;
use App\Http\Requests\StoreItemClassRequest;
use App\Http\Requests\UpdateItemClassRequest;
use App\Models\ItemClass;
use App\Models\ItemType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemClassController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('item_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itemClasses = ItemClass::with(['item_type'])->get();

        return view('admin.itemClasses.index', compact('itemClasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('item_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_types = ItemType::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.itemClasses.create', compact('item_types'));
    }

    public function store(StoreItemClassRequest $request)
    {
        $itemClass = ItemClass::create($request->all());

        return redirect()->route('admin.item-classes.index')->with('created', 'New Item Class Added.');
    }

    public function edit(ItemClass $itemClass)
    {
        abort_if(Gate::denies('item_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_types = ItemType::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $itemClass->load('item_type');

        return view('admin.itemClasses.edit', compact('itemClass', 'item_types'));
    }

    public function update(UpdateItemClassRequest $request, ItemClass $itemClass)
    {
        $itemClass->update($request->all());

        return redirect()->route('admin.item-classes.index')->with('updated', 'Item Class Updated.');
    }

    public function destroy(ItemClass $itemClass)
    {
        abort_if(Gate::denies('item_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $itemClass->delete();

        return back()->with('deleted', 'Item Class Deleted.');
    }

    public function massDestroy(MassDestroyItemClassRequest $request)
    {
        $itemClasses = ItemClass::find(request('ids'));

        foreach ($itemClasses as $itemClass) {
            $itemClass->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function get_by_item_type(Request $request)
    {

        abort_if(Gate::denies('item_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (! $request->item_type_id) {
            $html = '<option value="">'.trans('global.pleaseSelect').'</option>';
        } else {
            $html = '';
            $itemClasses = ItemClass::where('item_type_id', $request->item_type_id)->get();

            foreach ($itemClasses as $itemClass) {
                $html .= '<option value="'.$itemClass->id.'">'.$itemClass->name.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }
}
