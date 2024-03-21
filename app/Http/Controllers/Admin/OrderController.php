<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChangeTableTopEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Item;
use App\Models\Member;
use App\Models\Menu;
use App\Models\MenuItemCategory;
use App\Models\Order;
use App\Models\TableTop;
use App\Models\User;
use Carbon\Carbon;
use Config;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            
            $fromDate = $request->has('fromDate') ? $request->fromDate : '';
            $toDate = $request->has('toDate') ? $request->toDate : date('d-m-Y');
            $orderStatus = $request->orderStatus ? $request->orderStatus : null;
            $completeStatusRoute = request('status') ? request('status') : null;
            
            
            $query = Order::with(['user', 'member', 'items', 'tableTop'])->select(sprintf('%s.*', (new Order)->table));

            if($completeStatusRoute != null){
                $query->where('status' ,'=', request('status'));
            }
            
            if($orderStatus && $orderStatus != 'all'){
                $query->where('status','=',$request->orderStatus);
            }
            else{
                $query->where('status','!=',Order::STATUS_SELECT['Complete']);
            }
            
            if(!empty($fromDate)){
                $query->whereBetween(DB::raw('DATE(created_at)'), [Carbon::createFromFormat('d-m-Y', $fromDate)->toDateString(), Carbon::createFromFormat('d-m-Y', $toDate)->toDateString()]);
            }

            
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {

                $viewGate = 'order_show';
                if ($row->status == 'Complete') {
                    $editGate = '';

                } else {
                    $editGate = 'order_edit';
                }
                $deleteGate = 'order_delete';
                $crudRoutePart = 'orders';

                return view('admin.orders.datatablesActions', compact(
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

            // $table->editColumn('table_top.code', function ($row) {
            //     return $row->table_top;
            // });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('member_name', function ($row) {
                return $row->member ? $row->member->name : '';
            });

            $table->editColumn('member.membership_no', function ($row) {
                return $row->member ? (is_string($row->member) ? $row->member : $row->member->membership_no) : '';
            });
            $table->editColumn('member.cell_no', function ($row) {
                return $row->member ? (is_string($row->member) ? $row->member : $row->member->cell_no) : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Order::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('item_discount', function ($row) {
                return $row->item_discount ? $row->item_discount : '';
            });
            $table->editColumn('sub_total', function ($row) {
                return $row->sub_total ? $row->sub_total : '';
            });
            $table->editColumn('tax', function ($row) {
                return $row->tax ? $row->tax : '';
            });
            $table->editColumn('total', function ($row) {
                return $row->total ? $row->total : '';
            });
            $table->editColumn('promo', function ($row) {
                return $row->promo ? $row->promo : '';
            });
            $table->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount : '';
            });
            $table->editColumn('grand_total', function ($row) {
                return $row->grand_total ? $row->grand_total : '';
            });
            $table->editColumn('item', function ($row) {
                $labels = [];
                foreach ($row->items as $item) {
                    $labels[] = sprintf('<span class="badge badge-info">%s</span>', $item->title);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('floor', function ($row) {
                // $printers = Config::get('printers');

                // $floorName = array_search($row->floor,$printers);

                // foreach($printers as $printer) {

                //     if($printer['id'] == $row->floor){
                //         return $printer['name'];
                //     }

                // }

            });

            $table->editColumn('status_color', function ($row) {
                return $row->status && Order::STATUS_COLOR[$row->status] ? Order::STATUS_COLOR[$row->status] : 'none';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'member', 'item', 'table_top', 'floor']);
            
            // if ($request->status == 'Complete') {
            //     // Load the view for completed orders

            //     return $table->make(true);
            //     // return view('admin.orders.completed_orders')->with('dataTable', $table->make(true));
            // } else {
            //     // Load the default view for other orders
            //     return $table->make(true);
            // }

            return $table->make(true);
        }

        return view('admin.orders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = MenuItemCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = Member::select('name', 'id', 'membership_no')->get();

        $items = Item::pluck('title', 'id');

        $tableTops = TableTop::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $printers = Config::get('printers');

        return view('admin.orders.create', compact('items', 'members', 'users', 'menus', 'categories', 'tableTops', 'printers'));
    }

    public function store(StoreOrderRequest $request)
    {
        // dd($request->all());
        $order = Order::create([
            'user_id' => auth()->id(),
            'no_of_guests' => $request->no_of_guests,
            'status' => $request->status,
            'member_id' => $request->member_id,
            'table_top_id' => $request->table_top_id,
            'menu_id' => $request->menu_id,
            'floor' => $request->floor,
        ]);

        $order->items()->sync($request->input('items', []));

        $this->calculate_total_after_update_order($request->items, $order);

        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = MenuItemCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = Member::select('name', 'id', 'membership_no')->get();

        $items = Item::pluck('title', 'id');

        $tableTops = TableTop::where('status', '!=', 'active')->orWhere('id', $order->table_top_id)->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $order->load('user', 'member', 'items');

        $printers = Config::get('printers');

        return view('admin.orders.edit', compact('items', 'members', 'users', 'menus', 'categories', 'tableTops', 'order', 'printers'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {

        $order->update($request->all());

        $order
            ->items()
            ->sync($this->mapItemValues($request->items));

        // $data['id'] = $order->table_top_id;
        // $data['status'] = $order->table_top_id;

        // ChangeTableTopEvent::dispatch($data);
        $this->calculate_total_after_update_order($request->items, $order);

        return redirect()->route('admin.orders.index');
    }

    protected function mapItemValues($items)
    {

        $syncData = collect($items)->mapWithKeys(function ($itemAttributes, $itemId) {

            return [$itemAttributes['item_id'] => [
                // return [$itemId => [
                'quantity' => $itemAttributes['quantity'],
                // 'content' => $itemAttributes['content'],
                'price' => $itemAttributes['price'],
                'item_id' => $itemAttributes['item_id'],
                'menu_id' => $itemAttributes['menu_id'],
            ]];
        })->all();

        return $syncData;
    }

    protected function calculate_total_after_update_order($items, Order $order)
    {

        // dd($items);
        $sum = collect($items)
            ->reduce(function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

        $order->fill(['grand_total' => $sum, 'total' => $sum]);
        $order->update();
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('user', 'member', 'items', 'orderTransactions');

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        $orders = Order::find(request('ids'));

        foreach ($orders as $order) {
            $order->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
