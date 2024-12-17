<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTableTopRequest;
use App\Http\Requests\StoreTableTopRequest;
use App\Http\Requests\UpdateTableTopRequest;
use App\Models\TableTop;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TableTopController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('table_top_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TableTop::query()->select(sprintf('%s.*', (new TableTop)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'table_top_show';
                $editGate = 'table_top_edit';
                $deleteGate = 'table_top_delete';
                $crudRoutePart = 'table-tops';

                return view('partials.'.tenant()->id.'.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->editColumn('capacity', function ($row) {
                return $row->capacity ? $row->capacity : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? TableTop::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.tableTops.index');
    }

    public function create()
    {
        abort_if(Gate::denies('table_top_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tableTops.create');
    }

    public function store(StoreTableTopRequest $request)
    {
        $tableTop = TableTop::create($request->all());

        return redirect()->route('admin.table-tops.index')->with('created', 'New Table Top Added.');
    }

    public function edit(TableTop $tableTop)
    {
        abort_if(Gate::denies('table_top_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tableTops.edit', compact('tableTop'));
    }

    public function update(UpdateTableTopRequest $request, TableTop $tableTop)
    {
        $tableTop->update($request->all());

        return redirect()->route('admin.table-tops.index')->with('updated', 'Table Top Updated.');
    }

    public function show(TableTop $tableTop)
    {
        abort_if(Gate::denies('table_top_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tableTops.show', compact('tableTop'));
    }

    public function destroy(TableTop $tableTop)
    {
        abort_if(Gate::denies('table_top_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tableTop->delete();

        return back()->with('deleted', 'Table Top Deleted.');
    }

    public function massDestroy(MassDestroyTableTopRequest $request)
    {
        $tableTops = TableTop::find(request('ids'));

        foreach ($tableTops as $tableTop) {
            $tableTop->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
