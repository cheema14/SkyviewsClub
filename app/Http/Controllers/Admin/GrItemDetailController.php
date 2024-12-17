<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGrItemDetailRequest;
use App\Http\Requests\StoreGrItemDetailRequest;
use App\Http\Requests\UpdateGrItemDetailRequest;
use App\Models\GoodReceipt;
use App\Models\GrItemDetail;
use App\Models\StoreItem;
use App\Models\Unit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GrItemDetailController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('gr_item_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = GrItemDetail::with(['item', 'unit', 'gr'])->select(sprintf('%s.*', (new GrItemDetail)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'gr_item_detail_show';
                $editGate = 'gr_item_detail_edit';
                $deleteGate = 'gr_item_detail_delete';
                $crudRoutePart = 'gr-item-details';

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
            $table->addColumn('item_name', function ($row) {
                return $row->item ? $row->item->name : '';
            });

            $table->addColumn('unit_type', function ($row) {
                return $row->unit ? $row->unit->type : '';
            });

            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('unit_rate', function ($row) {
                return $row->unit_rate ? $row->unit_rate : '';
            });
            $table->editColumn('total_amount', function ($row) {
                return $row->total_amount ? $row->total_amount : '';
            });

            $table->addColumn('gr_gr_number', function ($row) {
                return $row->gr ? $row->gr->gr_number : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'item', 'unit', 'gr']);

            return $table->make(true);
        }

        return view('admin.grItemDetails.index');
    }

    public function create()
    {
        abort_if(Gate::denies('gr_item_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = StoreItem::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $grs = GoodReceipt::pluck('gr_number', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        return view('admin.grItemDetails.create', compact('grs', 'items', 'units'));
    }

    public function store(StoreGrItemDetailRequest $request)
    {
        $grItemDetail = GrItemDetail::create($request->all());

        return redirect()->route('admin.gr-item-details.index');
    }

    public function edit(GrItemDetail $grItemDetail)
    {
        abort_if(Gate::denies('gr_item_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = StoreItem::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $units = Unit::pluck('type', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $grs = GoodReceipt::pluck('gr_number', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $grItemDetail->load('item', 'unit', 'gr');

        return view('admin.grItemDetails.edit', compact('grItemDetail', 'grs', 'items', 'units'));
    }

    public function update(UpdateGrItemDetailRequest $request, GrItemDetail $grItemDetail)
    {
        $grItemDetail->update($request->all());

        return redirect()->route('admin.good-receipts.index');
    }

    public function show(GrItemDetail $grItemDetail)
    {
        abort_if(Gate::denies('gr_item_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grItemDetail->load('item', 'unit', 'gr');

        return view('admin.grItemDetails.show', compact('grItemDetail'));
    }

    public function destroy(GrItemDetail $grItemDetail)
    {
        abort_if(Gate::denies('gr_item_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grItemDetail->delete();

        return redirect()->route('admin.good-receipts.index');
    }

    public function massDestroy(MassDestroyGrItemDetailRequest $request)
    {
        $grItemDetails = GrItemDetail::find(request('ids'));

        foreach ($grItemDetails as $grItemDetail) {
            $grItemDetail->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
