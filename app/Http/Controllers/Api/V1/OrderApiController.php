<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\PrintKitchenReceiptEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiResponser;
use App\Models\Order;
use App\Models\TableTop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    use ApiResponser;

    protected $table_occupied_flag = false;

    public function placeOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'member_id' => 'required|exists:members,id',
            'items' => 'required',
            // 'table_id' => [
            //     'required',
            //     function ($attribute, $value, $fail) {
            //         $table = TableTop::find($value);

            //         if (! $table || $table->status !== 'free') {

            //             $this->table_occupied_flag = true;

            //         }
            //     },
            // ],
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        if ($this->table_occupied_flag) {
            return $this->error(__('apis.order.tableOccupied'), 200);
        }

        // dd($request->all());
        $order = Order::create(
            [
                'user_id' => $request->user_id,
                'member_id' => $request->member_id,
                'status' => 'New',
                'table_top_id' => $request->table_id,
                'no_of_guests' => $request->no_of_guests,
                'payment_type' => $request->payment_type,
            ]
        );

        $order->items()->attach($request->items);

        // Change status of the table

        $tableTop = TableTop::find($request->table_id);
        $tableTop->fill(['status' => 'active']);
        $tableTop->update();

        // Update the total amount of order
        $sum = collect($order->items)
            ->reduce(function ($carry, $item) {
                return $carry + ($item->pivot->price * $item->pivot->quantity);
            }, 0);

        $order->fill(['grand_total' => $sum, 'total' => $sum, 'status' => 'Active']);
        $order->update();

        // Load the order with items and table top for printing

        $data = $order->load('items', 'tableTop');

        PrintKitchenReceiptEvent::dispatch($data);

        return $this->success(
            ['order' => $order], __('apis.order.save')
        );
    }
}
