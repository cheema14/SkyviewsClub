@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.paymentHistory.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.paymentHistory.view-payment-history-list') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> 
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.paymentHistory.fields.name') }}
                        </th>
                        <td>
                            @if(isset($memberData) && !empty($memberData['name']))
                                {{  $memberData['name']  }}
                            @else
                                {{  'N/A'  }}
                            @endif
                        </td>
                        <th>
                            {{ trans(tenant()->id.'/cruds.paymentHistory.fields.membership_no') }}
                        </th>
                        <td>
                            @if(isset($memberData) && !empty($memberData['membership_no']))
                                {{  $memberData['membership_no']  }}
                            @else
                                {{  'N/A'  }}
                            @endif
                        </td>
                        <tr style="background: none;">
                            <td colspan="4"><hr class="divider"></td>
                        </tr>
                    </tr>
                    
                    @foreach ($paymentHistory as $key=> $history )
                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.receipt_no') }}
                            </th>
                            <td>
                                {{ $history->receipt_no }}
                            </td>

                            <th>
                                {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.receipt_date') }}
                            </th>
                            <td>
                                {{ $history->receipt_date }}
                            </td>

                        </tr>
                        
                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.invoice_amount') }}
                            </th>
                            <td>
                                {{ $history->invoice_amount }}
                            </td>

                            <th>
                                {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.received_amount') }}
                            </th>
                            <td>
                                {{ $history->received_amount }}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.pay_mode') }}
                            </th>
                            <td>
                                {{ $history->pay_mode }}
                            </td>
                            
                            <th>
                                {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.bill_type') }}
                            </th>
                            <td>
                                {{ $history->bill_type }}
                            </td>
                        </tr>
                        <tr style="background: none;">
                            <td colspan="4"><hr class="divider"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>


@endsection