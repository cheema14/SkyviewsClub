@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.order.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="form-group">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.id') }}
                        </th>
                        <td>
                            {{ $order->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.user') }}
                        </th>
                        <td>
                            {{ $order->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.member') }}
                        </th>
                        <td>
                            {{ $order->member->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Order::STATUS_SELECT[$order->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.item_discount') }}
                        </th>
                        <td>
                            {{ $order->item_discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.sub_total') }}
                        </th>
                        <td>
                            {{ $order->sub_total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.tax') }}
                        </th>
                        <td>
                            {{ $order->tax }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.total') }}
                        </th>
                        <td>
                            {{ $order->total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.promo') }}
                        </th>
                        <td>
                            {{ $order->promo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.discount') }}
                        </th>
                        <td>
                            {{ $order->discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.grand_total') }}
                        </th>
                        <td>
                            {{ $order->grand_total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.order.fields.item') }}
                        </th>
                        <td>
                            @foreach($order->items as $key => $item)
                                <span class="label label-info">{{ $item->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

{{-- <div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.relatedData') }}
        </h4>
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#order_transactions" role="tab" data-toggle="tab">
                {{ trans(tenant()->id.'/cruds.transaction.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="order_transactions">
            @includeIf('admin.orders.relationships.orderTransactions', ['transactions' => $order->orderTransactions])
        </div>
    </div>
</div> --}}

@endsection
