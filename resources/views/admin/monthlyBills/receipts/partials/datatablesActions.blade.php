<div class="dropdown text-center">
    <a class="dropdown-button" id="dropdown-menu-{{ $row->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v"></i>
    </a>
    
    <div class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $row->id }}">
        {{-- Where $row->id is the payment receipt ID --}}
        
        @can($viewGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.view-payment-receipt',['id' => $row->id]) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans('cruds.paymentReceipts.view_payment_receipt') }}
            </a>
        @endcan
        
        @can($downLoadGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.download-payment-receipt',['id' => $row->id]) }}">
                <i style="margin-right:10px; " class="fa fa-file fa-lg"></i>
                {{ trans('cruds.paymentReceipts.download_payment_receipt') }}
            </a>
        @endcan

    </div>
</div>

