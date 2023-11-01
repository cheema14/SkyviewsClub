<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStockIssueRequest;
use App\Http\Requests\StoreStockIssueRequest;
use App\Http\Requests\UpdateStockIssueRequest;
use App\Models\Employee;
use App\Models\Section;
use App\Models\StockIssue;
use App\Models\Store;
use App\Models\StoreItem;
use App\Models\Unit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StockIssueController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('stock_issue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StockIssue::with(['section', 'store', 'employee'])->select(sprintf('%s.*', (new StockIssue)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'stock_issue_show';
                $editGate      = 'stock_issue_edit';
                $deleteGate    = 'stock_issue_delete';
                $crudRoutePart = 'stock-issues';

                return view('partials.datatablesActions', compact(
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
            $table->editColumn('issue_no', function ($row) {
                return $row->issue_no ? $row->issue_no : '';
            });

            $table->addColumn('section_name', function ($row) {
                return $row->section ? $row->section->name : '';
            });

            $table->addColumn('store_name', function ($row) {
                return $row->store ? $row->store->name : '';
            });

            $table->addColumn('employee_name', function ($row) {
                return $row->employee ? $row->employee->name : '';
            });

            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'section', 'store', 'employee']);

            return $table->make(true);
        }

        return view('admin.stockIssues.index');
    }

    public function create()
    {

        abort_if(Gate::denies('stock_issue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stores = Store::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = StoreItem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $last_id = StockIssue::latest()->first();



        if(!$last_id?->id){
            $last_id = 1;
        }
        else{
            $last_id = $last_id->id + 1;
        }

        return view('admin.stockIssues.create', compact('employees', 'sections', 'stores','items', 'units','last_id'));
    }

    public function store(StoreStockIssueRequest $request)
    {
        $stockIssue = StockIssue::create($request->all());

        foreach($request->items as $key => $value){

            $stockIssue->stockIssueStockIssueItems()->create([
                'item_id' => $value['item_id'],
                'unit_id' => $value['unit_id'],
                'lot_no' => $value['lot_no'],
                'stock_required' => $value['stock_required'],
                'issued_qty' => $value['issued_qty'],
            ]);
        }

        return redirect()->route('admin.stock-issues.index');
    }

    public function edit(StockIssue $stockIssue)
    {
        abort_if(Gate::denies('stock_issue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stores = Store::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stockIssue->load('section', 'store', 'employee');

        return view('admin.stockIssues.edit', compact('employees', 'sections', 'stockIssue', 'stores'));
    }

    public function update(UpdateStockIssueRequest $request, StockIssue $stockIssue)
    {
        $stockIssue->update($request->all());

        return redirect()->route('admin.stock-issues.index');
    }

    public function show(StockIssue $stockIssue)
    {
        abort_if(Gate::denies('stock_issue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stockIssue->load('section', 'store', 'employee');

        return view('admin.stockIssues.show', compact('stockIssue'));
    }

    public function destroy(StockIssue $stockIssue)
    {
        abort_if(Gate::denies('stock_issue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stockIssue->delete();

        return back();
    }

    public function massDestroy(MassDestroyStockIssueRequest $request)
    {
        $stockIssues = StockIssue::find(request('ids'));

        foreach ($stockIssues as $stockIssue) {
            $stockIssue->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    // ----------------------------------------------------------------//
    // Fetch the lot no that are registered against an item
    // ----------------------------------------------------------------//

    public function get_lot_no_by_items(Request $request){

    }
}
