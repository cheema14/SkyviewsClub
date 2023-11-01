<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySportsDivisionRequest;
use App\Http\Requests\StoreSportsDivisionRequest;
use App\Http\Requests\UpdateSportsDivisionRequest;
use App\Models\SportsDivision;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SportsDivisionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sports_division_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportsDivisions = SportsDivision::all();

        return view('admin.sportsDivisions.index', compact('sportsDivisions'));
    }

    public function create()
    {
        abort_if(Gate::denies('sports_division_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sportsDivisions.create');
    }

    public function store(StoreSportsDivisionRequest $request)
    {
        $sportsDivision = SportsDivision::create($request->all());

        return redirect()->route('admin.sports-divisions.index')->with('created', 'New Sports Division Added.');
    }

    public function edit(SportsDivision $sportsDivision)
    {
        abort_if(Gate::denies('sports_division_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sportsDivisions.edit', compact('sportsDivision'));
    }

    public function update(UpdateSportsDivisionRequest $request, SportsDivision $sportsDivision)
    {
        $sportsDivision->update($request->all());

        return redirect()->route('admin.sports-divisions.index')->with('updated', 'Sports Division Updated.');
    }

    public function show(SportsDivision $sportsDivision)
    {
        abort_if(Gate::denies('sports_division_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sportsDivisions.show', compact('sportsDivision'));
    }

    public function destroy(SportsDivision $sportsDivision)
    {
        abort_if(Gate::denies('sports_division_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sportsDivision->delete();

        return back()->with('deleted', 'Sports Division Deleted.');
    }

    public function massDestroy(MassDestroySportsDivisionRequest $request)
    {
        $sportsDivisions = SportsDivision::find(request('ids'));

        foreach ($sportsDivisions as $sportsDivision) {
            $sportsDivision->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
