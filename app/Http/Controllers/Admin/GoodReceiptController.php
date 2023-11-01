<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGoodReceiptRequest;
use App\Http\Requests\StoreGoodReceiptRequest;
use App\Http\Requests\UpdateGoodReceiptRequest;
use App\Models\GoodReceipt;
use App\Models\Store;
use App\Models\StoreItem;
use App\Models\Unit;
use App\Models\Vendor;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GoodReceiptController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('good_receipt_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = GoodReceipt::with(['store', 'vendor'])->select(sprintf('%s.*', (new GoodReceipt)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'good_receipt_show';
                $editGate = 'good_receipt_edit';
                $deleteGate = 'good_receipt_delete';
                $crudRoutePart = 'good-receipts';

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
            $table->editColumn('gr_number', function ($row) {
                return $row->gr_number ? $row->gr_number : '';
            });
            $table->addColumn('store_name', function ($row) {
                return $row->store ? $row->store->name : '';
            });

            $table->addColumn('vendor_name', function ($row) {
                return $row->vendor ? $row->vendor->name : '';
            });

            $table->editColumn('pay_type', function ($row) {
                return $row->pay_type ? GoodReceipt::PAY_TYPE_SELECT[$row->pay_type] : '';
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'store', 'vendor']);

            return $table->make(true);
        }

        return view('admin.goodReceipts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('good_receipt_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stores = Store::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vendors = Vendor::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $items = StoreItem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $items = StoreItem::get();

        $units = Unit::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $grs = GoodReceipt::pluck('gr_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $goodReceipt = GoodReceipt::latest()->withTrashed()->first();

        if (! $goodReceipt?->id) {
            $last_id = 1;
        } else {
            $last_id = $goodReceipt->id + 1;
        }

        return view('admin.goodReceipts.create', compact('stores', 'vendors', 'grs', 'items', 'units', 'last_id'));
    }

    public function store(StoreGoodReceiptRequest $request)
    {

        $goodReceipt = GoodReceipt::create($request->all());

        foreach ($request->items as $key => $value) {

            $goodReceipt->grGrItemDetails()->create([
                'item_id' => $value['item_id'],
                'unit_id' => $value['unit_id'],
                'quantity' => $value['quantity'],
                'total_amount' => $value['total_amount'],
                'unit_rate' => $value['unit_rate'],
                'expiry_date' => $value['expiry_date'],
                // 'purchase_date' => $value['purchase_date']
            ]);
        }

        return redirect()->route('admin.good-receipts.index');
    }

    public function edit(GoodReceipt $goodReceipt)
    {
        abort_if(Gate::denies('good_receipt_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stores = Store::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vendors = Vendor::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $goodReceipt->load('store', 'vendor');

        return view('admin.goodReceipts.edit', compact('goodReceipt', 'stores', 'vendors'));
    }

    public function update(UpdateGoodReceiptRequest $request, GoodReceipt $goodReceipt)
    {
        $goodReceipt->update($request->all());

        return redirect()->route('admin.good-receipts.index');
    }

    public function show(GoodReceipt $goodReceipt)
    {
        abort_if(Gate::denies('good_receipt_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $goodReceipt->load('store', 'vendor', 'grGrItemDetails');

        return view('admin.goodReceipts.show', compact('goodReceipt'));
    }

    public function destroy(GoodReceipt $goodReceipt)
    {
        abort_if(Gate::denies('good_receipt_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $goodReceipt->delete();

        return back();
    }

    public function massDestroy(MassDestroyGoodReceiptRequest $request)
    {
        $goodReceipts = GoodReceipt::find(request('ids'));

        foreach ($goodReceipts as $goodReceipt) {
            $goodReceipt->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
