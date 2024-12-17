@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>
    .dataTables_scrollBody, .dataTables_wrapper {
        position: static !important;
    }
    .dropdown-button {
        cursor: pointer;
        font-size: 2em;
        display:block
    }
    .dropdown-menu i {
        font-size: 1.33333333em;
        line-height: 0.75em;
        vertical-align: -15%;
        color: #000;
    }
</style>
@endsection
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <h4>
        {{ trans(tenant()->id.'/cruds.paymentReceipts.title') }} {{ trans(tenant()->id.'/global.list') }}
        </h4>
        {{-- <a class="btn btn-success" href="{{ route('admin.monthlyBilling.create-advance-payment-receipt') }}">
            {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.paymentReceipts.create_advance_payment') }}
        </a> --}}
    </div>
    
</div>
<div class="card">
    <div class="card-header">
        
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Payment-Receipts">
            <thead>
                <tr>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.receipt_date') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.membership_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.name') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.pay_mode') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.received_amount') }}
                    </th>
                    {{-- <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.receipt_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.bill_type') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.billing_month') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.invoice_number') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentReceipts.fields.invoice_amount') }}
                    </th> --}}
                    
                    <th>
                        {{ trans(tenant()->id.'/global.action') }}
                    </th>
                </tr>
            </thead>
        </table>
    </div>


</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            ordering:true,
            ajax: "{{ route('admin.monthlyBilling.get-all-receipts') }}",
            columns: [
            { data: 'id', name: 'id' },
            { data: 'receipt_date', name: 'receipt_date' },
            { data: 'member.membership_no', name: 'member.membership_no' },
            { data: 'member.name', name: 'member.name' },
            { data: 'pay_mode', name: 'pay_mode' },
            { data: 'received_amount', name: 'received_amount' },
            // { data: 'receipt_no', name: 'receipt_no' },
            // { data: 'bill_type', name: 'bill_type' },
            // { data: 'billing_month', name: 'billing_month' },
            // { data: 'invoice_number', name: 'invoice_number' },
            // { data: 'invoice_amount', name: 'invoice_amount' },
            { data: 'actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
            ],
            orderCellsTop: true,
            pageLength: 15,
        };
        let table = $('.datatable-Payment-Receipts').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection