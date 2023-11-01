<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySportItemClassRequest;
use App\Http\Requests\StoreSportItemClassRequest;
use App\Http\Requests\UpdateSportItemClassRequest;
use App\Models\SportItemClass;
use App\Models\SportItemType;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SportItemClassController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sport_item_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemClasses = SportItemClass::with(['item_type'])->get();

        return view('admin.sportItemClasses.index', compact('sportItemClasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('sport_item_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_types = SportItemType::pluck('item_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sportItemClasses.create', compact('item_types'));
    }

    public function store(StoreSportItemClassRequest $request)
    {
        $sportItemClass = SportItemClass::create($request->all());

        return redirect()->route('admin.sport-item-classes.index')->with('created', 'New Sports Item Class Added.');
    }

    public function edit(SportItemClass $sportItemClass)
    {
        abort_if(Gate::denies('sport_item_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_types = SportItemType::pluck('item_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sportItemClass->load('item_type');

        return view('admin.sportItemClasses.edit', compact('item_types', 'sportItemClass'));
    }

    public function update(UpdateSportItemClassRequest $request, SportItemClass $sportItemClass)
    {
        $sportItemClass->update($request->all());

        return redirect()->route('admin.sport-item-classes.index')->with('updated', 'Sports Item Class Updated.');
    }

    public function show(SportItemClass $sportItemClass)
    {
        abort_if(Gate::denies('sport_item_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemClass->load('item_type');

        return view('admin.sportItemClasses.show', compact('sportItemClass'));
    }

    public function destroy(SportItemClass $sportItemClass)
    {
        abort_if(Gate::denies('sport_item_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemClass->delete();

        return back()->with('deleted', 'Sports Item Type Deleted.');
    }

    public function massDestroy(MassDestroySportItemClassRequest $request)
    {
        $sportItemClasses = SportItemClass::find(request('ids'));

        foreach ($sportItemClasses as $sportItemClass) {
            $sportItemClass->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
