<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitRequest;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class UnitController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::all();

        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        abort_if(Gate::denies('unit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.units.create');
    }

    public function store(StoreUnitRequest $request)
    {
        $unit = Unit::create($request->all());

        return redirect()->route('admin.units.index')->with('created', 'New Unit Added.');
    }

    public function edit(Unit $unit)
    {
        abort_if(Gate::denies('unit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.units.edit', compact('unit'));
    }

    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->all());

        return redirect()->route('admin.units.index')->with('updated', 'Unit Updated.');
    }

    public function destroy(Unit $unit)
    {
        abort_if(Gate::denies('unit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit->delete();

        return back()->with('deleted', 'Unit Deleted.');
    }

    public function massDestroy(MassDestroyUnitRequest $request)
    {
        $units = Unit::find(request('ids'));

        foreach ($units as $unit) {
            $unit->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
