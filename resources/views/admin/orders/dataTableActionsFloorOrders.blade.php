<div class="dropdown text-center">
    <a class="dropdown-button" id="dropdown-menu-{{ $row->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $row->id }}">

        @can($viewGate)

            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans('global.view') }}
            </a>
        @endcan
        @can($editGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-edit fa-lg"></i>
                {{ trans('global.edit') }}
            </a>
        @endcan
        @can($deleteGate)
        <form id="delete-{{ $row->id }}" action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
        {{-- <a class="dropdown-item" href="#" onclick="if(confirm('{{ trans('global.areYouSure') }}')) document.getElementById('delete-{{ $row->id }}').submit()">
            <i style="margin-right:10px; " class="fa fa-trash"></i>
            {{ trans('global.delete') }}
        </a> --}}
        @endcan
        {{-- @if ($row->status == 'New' || $row->status == 'Active')

        @endif --}}
        <a target="_blank" class="dropdown-item performAction" href="{{ route('admin.print-kitchen-receipt', $row->id) }}">
            <i style="margin-right:10px; " class="fa fa-print fa-lg"></i>
            {{ trans('cruds.order.fields.print_kitchen_receipt') }}
        </a>

        {{-- @if ($row->status == 'Active')

            <a target="_blank" class="dropdown-item performAction" href="{{ route('admin.print-order-receipt' , $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-money fa-lg"></i>
                {{ trans('cruds.order.fields.print_order_receipt') }}
            </a>
        @endif --}}

        @if ($row->status == App\Models\Order::STATUS_SELECT["InProgress"])
            <a target="_blank" class="dropdown-item performAction" href="{{ route('admin.cash-receipt' , $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-money fa-lg"></i>
                {{ trans('cruds.cash_receipts.fields.print_cash_receipt') }}
            </a>
        @endif

        @if ($row->status == App\Models\Order::STATUS_SELECT["Complete"] || $row->status == App\Models\Order::STATUS_SELECT["Active"] || $row->status == App\Models\Order::STATUS_SELECT["InProgress"] )
            <a target="_blank" class="dropdown-item performAction" href="{{ route('admin.print-customer-bill' , $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-money fa-lg"></i>
                {{ trans('cruds.cash_receipts.fields.print_customer_receipt') }}
            </a>
        @endif

    </div>
</div>

