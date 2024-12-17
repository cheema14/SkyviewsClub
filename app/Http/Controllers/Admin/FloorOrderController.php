<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;


class FloorOrderController extends Controller
{
    public function list_floor_orders(Request $request){
        
        abort_if(Gate::denies('order_floor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            
            $fromDate = $request->has('fromDate') ? $request->fromDate : '';
            $toDate = $request->has('toDate') ? $request->toDate : date('d-m-Y');
            $orderStatus = $request->orderStatus ? $request->orderStatus : null;
            $completeStatusRoute = request('status') ? request('status') : null;
            
            $menu_id = auth()->user()->roles()->first()?->menus()->get()->pluck('id');
            // dd($menu_id);
            // $query = Order::with(['user', 'member', 'items', 'tableTop'])->select(sprintf('%s.*', (new Order)->table));
            $query = Order::with(['user', 'member', 'tableTop','items'])->select(sprintf('%s.*', (new Order)->table))
                            ->whereHas('items', function ($query) use ($menu_id) {
                                $query->whereIn('menu_id', $menu_id);
                            });

            // dd($query->count());

            if($completeStatusRoute != null){
                $query->where('status' ,'=', request('status'));
            }
            
            if($orderStatus && $orderStatus != 'all'){
                $query->where('status','=',$request->orderStatus);
            }
            else{
                if(! $completeStatusRoute){
                    $query->where('status','!=',Order::STATUS_SELECT['Complete']);
                }
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

                return view('admin.orders.dataTableActionsFloorOrders', compact(
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
                $menuIds = auth()->user()->roles()->first()?->menus()->get()->pluck('id')->toArray();
                
                foreach ($row->items as $item) {
                    if(in_array($item->pivot->menu_id, $menuIds)){
                        $labels[] = sprintf('<span class="badge badge-info">%s</span>', $item->pivot->quantity .' X '. $item->title);
                    }
                    
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

        return view('admin.floorOrders.index');
    }
}
