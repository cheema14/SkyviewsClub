@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>
    .no-background{
        background: none !important;
    }
</style>
@endsection
@include('partials.'.tenant()->id.'.flash_messages')

<div class="card">
    
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.title') }} {{ trans(tenant()->id.'/global.list') }}
        </h4>
        <form style="margin-top:50px;" method="GET" action="{{ route('admin.monthlyBilling.get-old-bills') }}">
            <div class="row">
                
                <div class="form-group col-md-4 generate_bills">
                    <label for="billing_month">{{ trans(tenant()->id.'/cruds.monthlyBilling.billing_invoice.billing_month') }}</label>
                    <select class="form-control {{ $errors->has('billing_month') ? 'is-invalid' : '' }}" name="billing_month" id="billing_month">
                        <option value disabled {{ old('billing_month', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                            @foreach(App\Models\Bill::BILLING_MONTHS as $key => $label)
                                @if ($key < now()->format('m'))
                                    <option value="{{ $key }}" {{ old('billing_month', '') === (string) $key ? 'selected' : '' }}>{{ $label }} - {{ date('Y') }}</option>
                                @endif
                            @endforeach
                    </select>
                </div>

                <input type="hidden" name="invoice_due_date" id="invoice_due_date" class="form-control" value="">

                <div class="form-group col-md-3">
                    <label for="bill_status">{{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.bill_status') }}</label>
                    <select class="form-control select2 {{ $errors->has('bill_status') ? 'is-invalid' : '' }}" name="bill_status" id="bill_status">
                        <option value="" disabled selected>Select Category</option>
                        @foreach (App\Models\Bill::BILL_STATUS as $bill_status )
                            <option value="{{ $bill_status }}" {{ request('bill_status') == $bill_status ? 'selected' : '' }}>{{ $bill_status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="membership_no">{{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.membership_no') }}</label>
                    <select class="form-control select2 {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" name="membership_no" id="membership_no">
                        <option value="" disabled selected>Select Category</option>
                        @foreach (App\Models\Member::all() as $member )
                            <option value="{{ $member->id }}" {{ request('membership_no') == $member->id ? 'selected' : '' }}>{{ $member->membership_no }} - {{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" id="find_member_payments" class="btn btn-info">Search</button>
            <a href="{{ route('admin.monthlyBilling.get-old-bills') }}" class="btn btn-danger">Reset</a>
        </form>
    </div>

    <div class="card-body">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-memberPayments">
                    <thead>
                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.id') }}
                            </th>
                            <th>
                                {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.member_name') }}
                            </th>
                            <th>
                                {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.membership_no') }}
                            </th>
                            <th>
                                {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.total') }}
                            </th>
                            <th>
                                {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.bill_month') }}
                            </th>
                            <th class="text-center">
                                {{ trans(tenant()->id.'/cruds.monthlyBilling.oldBills.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member_payments as $payment )
                        
                            <tr data-entry-id="{{ $payment->id }}">
                                <td>{{ $payment->id }}</td>    
                                <td>{{ $payment->member?->name }}</td>    
                                <td>{{ $payment->member?->membership_no }}</td>    
                                <td>{{ $payment->total }}</td>    
                                <td>{{ $payment->bill_month }}</td>    
                                <td>
                                    <a class="dropdown-item" target="_blank" href="{{ route('admin.monthlyBilling.view-old-bill',['id' => $payment->id ,'bill_month' => $payment->bill_month ]) }}">
                                        <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                                        {{ trans(tenant()->id.'/cruds.monthlyBilling.view_bill') }}
                                    </a>
                                </td>    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            // order: [[ 1, 'desc' ]],
            pageLength: 20,
            
            });
        let table = $('.datatable-memberPayments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
  
    })

    
    $(document).on("change","#billing_month",function(){
            
            let billing_month = $("#billing_month").val();
            let lastDay = new Date(new Date().getFullYear(), billing_month, 0).getDate();
            // let fifteenthDay = new Date(year, month, 15);
            // lastDay = fifteenthDay;
            let monthNames = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];
            
            // because array index starts from 0
            // month value starts from 1 inside the model Bill.php
            // so minus 1 is needed

            let month = monthNames[billing_month - 1];

            let year = new Date().getFullYear();
            
            $("#invoice_due_date").val(lastDay+"-"+month+"-"+year);
            
        });

</script>


@endsection