<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySportItemTypeRequest;
use App\Http\Requests\StoreSportItemTypeRequest;
use App\Http\Requests\UpdateSportItemTypeRequest;
use App\Models\SportItemType;
use App\Models\SportsDivision;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SportItemTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sport_item_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemTypes = SportItemType::with('sportsDivision')->get();

        return view('admin.sportItemTypes.index', compact('sportItemTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('sport_item_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $divisions = SportsDivision::pluck('division', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        return view('admin.sportItemTypes.create', compact('divisions'));
    }

    public function store(StoreSportItemTypeRequest $request)
    {
        $sportItemType = SportItemType::create($request->all());

        return redirect()->route('admin.sport-item-types.index')->with('created', 'New Sports Item Type Added.');
    }

    public function edit(SportItemType $sportItemType)
    {
        abort_if(Gate::denies('sport_item_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $divisions = SportsDivision::pluck('division', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $sportItemType->load('sportsDivision');

        return view('admin.sportItemTypes.edit', compact('divisions', 'sportItemType'));
    }

    public function update(UpdateSportItemTypeRequest $request, SportItemType $sportItemType)
    {
        $sportItemType->update($request->all());

        return redirect()->route('admin.sport-item-types.index')->with('updated', 'Sports Item Type Updated.');
    }

    public function show(SportItemType $sportItemType)
    {
        abort_if(Gate::denies('sport_item_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemType->load('sportsDivision');

        return view('admin.sportItemTypes.show', compact('sportItemType'));
    }

    public function destroy(SportItemType $sportItemType)
    {
        abort_if(Gate::denies('sport_item_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportItemType->delete();

        return back()->with('deleted', 'Sports Item Type Deleted.');
    }

    public function massDestroy(MassDestroySportItemTypeRequest $request)
    {
        $sportItemTypes = SportItemType::find(request('ids'));

        foreach ($sportItemTypes as $sportItemType) {
            $sportItemType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
