<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Unit;
use App\Models\StoreItem;
use App\Models\StockIssue;
use Illuminate\Http\Request;
use App\Models\StockIssueItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreStockIssueItemRequest;
use App\Http\Requests\UpdateStockIssueItemRequest;
use App\Http\Requests\MassDestroyStockIssueItemRequest;

class StockIssueItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('stock_issue_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StockIssueItem::with(['item', 'unit'])->select(sprintf('%s.*', (new StockIssueItem)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'stock_issue_item_show';
                $editGate      = 'stock_issue_item_edit';
                $deleteGate    = 'stock_issue_item_delete';
                $crudRoutePart = 'stock-issue-items';

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
            $table->addColumn('item_name', function ($row) {
                return $row->item ? $row->item->name : '';
            });

            $table->addColumn('unit_type', function ($row) {
                return $row->unit ? $row->unit->type : '';
            });

            $table->editColumn('lot_no', function ($row) {
                return $row->lot_no ? $row->lot_no : '';
            });
            $table->editColumn('stock_required', function ($row) {
                return $row->stock_required ? $row->stock_required : '';
            });
            $table->editColumn('issued_qty', function ($row) {
                return $row->issued_qty ? $row->issued_qty : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'item', 'unit']);

            return $table->make(true);
        }

        return view('admin.stockIssueItems.index');
    }

    public function create()
    {

        abort_if(Gate::denies('stock_issue_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = StoreItem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stock_issues  = StockIssue::all();

        return view('admin.stockIssueItems.create', compact('items', 'units','stock_issues'));
    }

    public function store(StoreStockIssueItemRequest $request)
    {
        $stockIssueItem = StockIssueItem::create($request->all());

        return redirect()->route('admin.stock-issue-items.index');
    }

    public function edit(StockIssueItem $stockIssueItem)
    {
        abort_if(Gate::denies('stock_issue_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = StoreItem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stockIssueItem->load('item', 'unit');

        $stock_issues  = StockIssue::all();

        return view('admin.stockIssueItems.edit', compact('items', 'stockIssueItem', 'units','stock_issues'));
    }

    public function update(UpdateStockIssueItemRequest $request, StockIssueItem $stockIssueItem)
    {
        $stockIssueItem->update($request->all());

        return redirect()->route('admin.stock-issue-items.index');
    }

    public function show(StockIssueItem $stockIssueItem)
    {
        abort_if(Gate::denies('stock_issue_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stockIssueItem->load('item', 'unit');

        return view('admin.stockIssueItems.show', compact('stockIssueItem'));
    }

    public function destroy(StockIssueItem $stockIssueItem)
    {
        abort_if(Gate::denies('stock_issue_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stockIssueItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyStockIssueItemRequest $request)
    {
        $stockIssueItems = StockIssueItem::find(request('ids'));

        foreach ($stockIssueItems as $stockIssueItem) {
            $stockIssueItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
