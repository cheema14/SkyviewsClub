<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySportItemNameRequest;
use App\Http\Requests\StoreSportItemNameRequest;
use App\Http\Requests\UpdateSportItemNameRequest;
use App\Models\SportItemClass;
use App\Models\SportItemName;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SportItemNameController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sport_item_name_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemNames = SportItemName::with(['item_class'])->get();

        return view('admin.sportItemNames.index', compact('sportItemNames'));
    }

    public function create()
    {
        abort_if(Gate::denies('sport_item_name_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_classes = SportItemClass::pluck('item_class', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sportItemNames.create', compact('item_classes'));
    }

    public function store(StoreSportItemNameRequest $request)
    {
        // dd($request->all());
        $sportItemName = SportItemName::create($request->all());

        return redirect()->route('admin.sport-item-names.index')->with('created', 'New Sports Item Name Added.');
    }

    public function edit(SportItemName $sportItemName)
    {
        abort_if(Gate::denies('sport_item_name_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_classes = SportItemClass::pluck('item_class', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sportItemName->load('item_class');

        return view('admin.sportItemNames.edit', compact('item_classes', 'sportItemName'));
    }

    public function update(UpdateSportItemNameRequest $request, SportItemName $sportItemName)
    {
        $sportItemName->update($request->all());

        return redirect()->route('admin.sport-item-names.index')->with('updated', 'Sports Item Name Updated.');
    }

    public function show(SportItemName $sportItemName)
    {
        abort_if(Gate::denies('sport_item_name_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemName->load('item_class');

        return view('admin.sportItemNames.show', compact('sportItemName'));
    }

    public function destroy(SportItemName $sportItemName)
    {
        abort_if(Gate::denies('sport_item_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemName->delete();

        return back()->with('deleted', 'Sports Item Name Deleted.');
    }

    public function massDestroy(MassDestroySportItemNameRequest $request)
    {
        $sportItemNames = SportItemName::find(request('ids'));

        foreach ($sportItemNames as $sportItemName) {
            $sportItemName->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
