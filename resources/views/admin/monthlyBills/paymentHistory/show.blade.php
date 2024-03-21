@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.paymentHistory.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.paymentHistory.view-payment-history-list') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.name') }}
                        </th>
                        <td>
                            {{ $memberData['name'] }}
                        </td>
                        <th>
                            {{ trans('cruds.paymentHistory.fields.membership_no') }}
                        </th>
                        <td>
                            {{ $memberData['membership_no'] }}
                        </td>
                        <tr style="background: none;">
                            <td colspan="4"><hr class="divider"></td>
                        </tr>
                    </tr>
                    
                    @foreach ($paymentHistory as $key=> $history )
                        <tr>
                            <th>
                                {{ trans('cruds.paymentReceipts.fields.receipt_no') }}
                            </th>
                            <td>
                                {{ $history->receipt_no }}
                            </td>

                            <th>
                                {{ trans('cruds.paymentReceipts.fields.receipt_date') }}
                            </th>
                            <td>
                                {{ $history->receipt_date }}
                            </td>

                        </tr>
                        
                        <tr>
                            <th>
                                {{ trans('cruds.paymentReceipts.fields.invoice_amount') }}
                            </th>
                            <td>
                                {{ $history->invoice_amount }}
                            </td>

                            <th>
                                {{ trans('cruds.paymentReceipts.fields.received_amount') }}
                            </th>
                            <td>
                                {{ $history->received_amount }}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>
                                {{ trans('cruds.paymentReceipts.fields.pay_mode') }}
                            </th>
                            <td>
                                {{ $history->pay_mode }}
                            </td>
                            
                            <th>
                                {{ trans('cruds.paymentReceipts.fields.bill_type') }}
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