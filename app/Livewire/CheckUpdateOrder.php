<?php

namespace App\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class CheckUpdateOrder extends Component
{

    public $count = 0;
    public $orders = [];

    protected $listeners = ['echo:orders,order.updated' => 'handleOrderUpdated'];

    public function mount()
    {
        $this->fetchUpdatedOrders();
    }

    public function handleOrderUpdated($order)
    {
        $this->orders[] = $order;
    }

    public function fetchUpdatedOrders()
    {
        $recentTimeFrame = Carbon::now()->subDay();

        $this->orders = Order::select('orders.id','orders.grand_total')->whereHas('items', function($query) use ($recentTimeFrame) {
            $query->where('item_order.new_added_item', true);
        })->get();

        // dd($this->orders);
    }

    public function render()
    {
        return view('livewire.check-update-order');
    }
}
