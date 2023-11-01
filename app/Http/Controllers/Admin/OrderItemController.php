<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderItemRequest;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = OrderItem::with(['order', 'item'])->select(sprintf('%s.*', (new OrderItem)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'order_item_show';
                $editGate      = 'order_item_edit';
                $deleteGate    = 'order_item_delete';
                $crudRoutePart = 'order-items';

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
            $table->addColumn('order_status', function ($row) {
                return $row->order ? $row->order->status : '';
            });

            $table->editColumn('order.grand_total', function ($row) {
                return $row->order ? (is_string($row->order) ? $row->order : $row->order->grand_total) : '';
            });
            $table->addColumn('item_title', function ($row) {
                return $row->item ? $row->item->title : '';
            });

            $table->editColumn('item.price', function ($row) {
                return $row->item ? (is_string($row->item) ? $row->item : $row->item->price) : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount : '';
            });
            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('content', function ($row) {
                return $row->content ? $row->content : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'order', 'item']);

            return $table->make(true);
        }

        return view('admin.orderItems.index');
    }

    public function create()
    {
        abort_if(Gate::denies('order_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.orderItems.create', compact('items', 'orders'));
    }

    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = OrderItem::create($request->all());

        return redirect()->route('admin.order-items.index');
    }

    public function edit(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $orderItem->load('order', 'item');

        return view('admin.orderItems.edit', compact('items', 'orderItem', 'orders'));
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->all());

        return redirect()->route('admin.order-items.index');
    }

    public function show(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderItem->load('order', 'item');

        return view('admin.orderItems.show', compact('orderItem'));
    }

    public function destroy(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderItemRequest $request)
    {
        $orderItems = OrderItem::find(request('ids'));

        foreach ($orderItems as $orderItem) {
            $orderItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
