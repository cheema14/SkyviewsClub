<div class="dropdown text-center">
    <a class="dropdown-button" id="dropdown-menu-{{ $row->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v"></i>
    </a>
    
    <div class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $row->id }}">
        {{-- Where $row->id is the member ID --}}
        
        @can($viewGate)
            <a class="dropdown-item" target="_blank" href="{{ route('admin.' . $crudRoutePart . '.view-due-bill',['id' => $row->id]) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans(tenant()->id.'/cruds.monthlyBilling.view_bill') }}
            </a>
        @endcan
        
        @can($printGate)
            @if ($row->bill_status != App\Models\Bill::BILL_STATUS['Paid'])            
                <a class="dropdown-item" target="_blank" href="{{ route('admin.' . $crudRoutePart . '.create-bill-receipt',['id' => $row->id]) }}">
                    <i style="margin-right:10px; " class="fa fa-edit fa-lg"></i>
                    {{ trans(tenant()->id.'/cruds.monthlyBilling.print_receipt') }}
                </a>
            @endif
        @endcan

    </div>
</div>

