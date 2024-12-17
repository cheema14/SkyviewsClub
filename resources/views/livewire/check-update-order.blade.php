
<div style="text-align: center">
    {{-- <button wire:click="increment">+</button> --}}
    
    <h1>Updated Orders</h1>
    <ul>
        @foreach($orders as $order)
            {{-- <li>Order ID: {{ $order->id }}</li> --}}
            <ul>
                @foreach($orders as $order)
                    <li>Order ID: {{ $order['id'] }} has been updated.</li>
                @endforeach
            </ul>
        @endforeach
    </ul>
</div>