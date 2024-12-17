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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PDF;
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
                    $editGate = 'order_edit';

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
            // $table->editColumn('item', function ($row) {
            //     $labels = [];
            //     foreach ($row->items as $item) {
            //         $labels[] = sprintf('<span class="badge badge-info">%s</span>', $item->title);
            //     }

            //     return implode(' ', $labels);
            // });

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

        return view('admin.orders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $categories = MenuItemCategory::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $members = Member::select('name', 'id', 'membership_no')->get();

        $items = Item::pluck('title', 'id');

        $tableTops = TableTop::where('status',TableTop::STATUS_SELECT['free'])->pluck('code', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

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

        // As In web interface
        // we do not have the JSON to fetch item title
        // so we are fetching it manually and one by one

        $requestItems = $request->items;
        foreach($requestItems as &$item){
            $item['title'] = $this->findItemName($item['item_id']);
            
            // Associate the tenant with the item_order row
            $item['tenant_id'] = tenant('id');
        }

        
        
        $order->items()->attach($requestItems);
    
        // $order->items()->sync($request->input('items', []));

        $this->calculate_total_after_update_order($request->items, $order);

        // Change the status of the Table which is occupied

        $tableTop = TableTop::find($request->table_top_id);
        $tableTop->fill(['status' => 'active']);
        $tableTop->update();


        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $categories = MenuItemCategory::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $members = Member::select('name', 'id', 'membership_no')->get();

        $items = Item::pluck('title', 'id');

        $tableTops = TableTop::where('status', '!=', 'active')->orWhere('id', $order->table_top_id)->pluck('code', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $order->load('user', 'member', 'items');

        $printers = Config::get('printers');

        return view('admin.orders.edit', compact('items', 'members', 'users', 'menus', 'categories', 'tableTops', 'order', 'printers'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        if($order->status == Order::STATUS_SELECT["Complete"]){
            $order->payment_type = $request->pay_mode;
            $order->update();
            
            return redirect()->route('admin.orders.index',['status'=>'Complete']);
        }

        $requestItems = $request->items;
        // Get the existing items from the order
        $existingItems = $order->items;

        $new_items_ids = array();
        $quantity_changed_items_ids = array();
        // Initialize arrays to track new and modified items
        $newItems = [];
        $modifiedItems = array();

        foreach($requestItems as &$item){
            $item['title'] = $this->findItemName($item['item_id']);
        }
        
        foreach ($requestItems as $requestItem) {
            $itemExists = $existingItems->first(function ($existingItem) use ($requestItem) {
                return $existingItem->pivot->item_id == $requestItem['item_id'];
            });
    
            if ($itemExists) {
                
                // Item exists, check if quantity has changed
                if ($itemExists->pivot->quantity < $requestItem['quantity']) {
                    // Quantity has changed, add to modifiedItems array
                    // $modifiedItems = $itemExists;
                    $modifiedItem = $requestItem;
                    $modifiedItem['new_quantity'] = $requestItem['quantity'] - $itemExists->pivot->quantity;
                    
                    $modifiedItems[] = $modifiedItem;
                    array_push($quantity_changed_items_ids,$requestItem['item_id']);
                }
            } else {
                // Item does not exist in the existingItems collection
                // It's a new item, add it to the newItems array

                // In the new_items_ids array we are pushing those items
                // which are newly added in an order
                // In order to print a New label with them or a new receipt entirely
                array_push($new_items_ids,$requestItem['item_id']);
                $newItems[] = $requestItem;

                
            }
        }
        // die;
        // dd($modifiedItems);
        $modified_labels = array_map(function($item) use ($new_items_ids, $quantity_changed_items_ids, $modifiedItems) {
            // Mark new added item
            $item['new_added_item'] = in_array($item['item_id'], $new_items_ids) ? 'yes' : 'no';
            // $item['new_quantity'] = in_array($item['item_id'], $quantity_changed_items_ids) ? $modifiedItems['new_quantity'] : 0;
            
 
            // Initialize new_quantity to 0
            $item['new_quantity'] = 0;
        
            if (in_array($item['item_id'], $quantity_changed_items_ids)) {
                foreach ($modifiedItems as $modifiedItem) {
                    if ($item['item_id'] == $modifiedItem['item_id']) {
                        // If the item exists in the modified items, assign the new_quantity
                        $item['new_quantity'] = $modifiedItem['new_quantity'];
                        break; // Break out of the loop once we find the item
                    }
                }
            }
        
            return $item;
        }, $request->items);

        // dd('111',$modified_labels);
        $requestItemsTwo = $modified_labels;
        
        foreach($requestItemsTwo as &$item){
            $item['title'] = $this->findItemName($item['item_id']);
        }
        
       
        $order
            ->items()
            ->sync($this->mapItemValues($requestItemsTwo));

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
                'new_quantity' => $itemAttributes['new_quantity'],
                'new_added_item' => $itemAttributes['new_added_item'],
                // 'content' => $itemAttributes['content'],
                'price' => $itemAttributes['price'],
                'item_id' => $itemAttributes['item_id'],
                'menu_id' => $itemAttributes['menu_id'],
                'title' => $itemAttributes['title'],
            ]];
        })->all();
        // dd($items,$syncData);
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

    public function export_pdf(Request $request)
    {   
        
        $range = $request->query('param');
        $date_range = '';
        
        // $range = 'month';
        if($range == 'today'){
            $date_range = now()->format('Y-m-d');

            $date_range = [$date_range,$date_range];
        }

        if($range == 'week'){
            $startOfWeek = now()->startOfWeek()->format('Y-m-d');
            $endOfWeek = now()->endOfWeek()->format('Y-m-d');

            // You can use the start and end dates for your query
            $date_range = [$startOfWeek, $endOfWeek]; // An array for range
        }

        if($range == 'month'){
            // Start of the month (1st day of the current month)
            $startOfMonth = now()->startOfMonth()->format('Y-m-d');

            // Today's date
            $endOfMonth = now()->format('Y-m-d');

            // You can use the start and end dates for your query
            $date_range = [$startOfMonth, $endOfMonth];
        }

        if($range == 'filter'){

            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $date_range = [$startDate, $endDate];
            }            
            
        }
        
        $allOrders = Order::with(['user', 'member', 'items', 'tableTop']) // Only load id and membership_no from the member
                            ->select('*') 
                            ->where('status','=',Order::STATUS_SELECT['Complete'])
                            ->whereBetween('created_at', $date_range)
                            ->get();
                            
                            $pdf = PDF::loadView('admin.orders.pdf_template', 
                            [
                            'allOrders' => $allOrders, 
                            ]);
        
        $check_print = $pdf->setOption('dpi', 300)->setOption('encoding', 'ASCII-85')
                       ->setPaper('a3', 'landscape') ->setOption('disable-smart-shrinking', true)
                       ->setOption('enable-local-file-access', true)
                       ->setOption('margin-left', 0)  // Remove left margin
                        ->setOption('margin-right', 0) // Remove right margin
                        ->setOption('margin-top', 0)   // Remove top margin
                        ->setOption('margin-bottom', 0); // Remove bottom margin
        
        
        
        $fileName = 'order_' . time() . '.pdf';
        $filePath = 'public/pdf/' . $fileName;  // Storage path in public folder

        Storage::put($filePath, $pdf->output());

        // Check if the file exists after saving
        if (!Storage::exists($filePath)) {
            return response()->json(['error' => 'File not saved properly!']);
        }

        $fileUrl = Storage::url($filePath);

        // Return the file URL in JSON response
        return response()->json([
            'file_url' => $fileUrl // This will be a public URL accessible by the browser
        ]);
        
        
    }

    public function export_pdf_active(Request $request){
        
        $range = $request->query('param');
        
        $status = $request->query('status') && $request->query('status') !== Order::STATUS_SELECT['Complete'] ? $request->query('status') : null;

        $date_range = '';   
        
        
        if($request->query('status') && $request->query('status') == Order::STATUS_SELECT['Complete']){
            $status = $request->query('status');
        }
        
        
        if($range == 'filter'){

            $startDate = Carbon::parse($request->query('start_date'))->format('Y-m-d');
            $endDate = Carbon::parse($request->query('end_date'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $date_range = [$startDate, $endDate];
            }            
            // dd($startDate,$endDate);
        }
        $allOrders = Order::with(['user', 'member', 'items', 'tableTop']) // Only load id and membership_no from the member
                            ->select('*') 
                            ->when($status, function ($query, $status) {
                                return $query->where('status', '=', $status); // Apply status only if it's set and not 'Complete'
                            })
                            ->where(DB::raw('DATE(created_at)'), '>=', $startDate)
                            ->where(DB::raw('DATE(created_at)'), '<=', $endDate)
                            // ->whereBetween('created_at', $date_range)
                            ->get();

        $pdf = PDF::loadView('admin.orders.pdf_template', ['allOrders' => $allOrders, ]);
        
        $check_print = $pdf->setOption('dpi', 300)->setOption('encoding', 'ASCII-85')
                       ->setPaper('a3', 'landscape') ->setOption('disable-smart-shrinking', true)
                       ->setOption('enable-local-file-access', true)
                       ->setOption('margin-left', 0)  // Remove left margin
                        ->setOption('margin-right', 0) // Remove right margin
                        ->setOption('margin-top', 0)   // Remove top margin
                        ->setOption('margin-bottom', 0); // Remove bottom margin

                $fileName = 'order_' . time() . '.pdf';
                $filePath = 'public/pdf/' . $fileName;  // Storage path in public folder
        
                Storage::put($filePath, $pdf->output());
        
                // Check if the file exists after saving
                if (!Storage::exists($filePath)) {
                    return response()->json(['error' => 'File not saved properly!']);
                }
        
                $fileUrl = Storage::url($filePath);
        
                // Return the file URL in JSON response
                return response()->json([
                    'file_url' => $fileUrl // This will be a public URL accessible by the browser
                ]);
        
        

        // return view('admin.orders.pdf_template',compact('allOrders'));
    }

    public function findItemName($itemId){
        
        $item_name = Item::where('id',$itemId)->get()->first();

        return $item_name->title ? $item_name->title : 'N/A';
    }
}
