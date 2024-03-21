@extends('layouts.admin')
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
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.paymentReceipts.title') }} {{ trans('global.list') }}
                </h4>
            </div>
            
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Payment-Receipts">
            <thead>
                <tr>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.member.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.member.fields.membership_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.receipt_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.receipt_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.bill_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.billing_month') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.invoice_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.invoice_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.received_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.paymentReceipts.fields.pay_mode') }}
                    </th>
                    <th>
                        {{ trans('global.action') }}
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
            { data: 'member.name', name: 'member.name' },
            { data: 'member.membership_no', name: 'member.membership_no' },
            { data: 'receipt_no', name: 'receipt_no' },
            { data: 'receipt_date', name: 'receipt_date' },
            { data: 'bill_type', name: 'bill_type' },
            { data: 'billing_month', name: 'billing_month' },
            { data: 'invoice_number', name: 'invoice_number' },
            { data: 'invoice_amount', name: 'invoice_amount' },
            { data: 'received_amount', name: 'received_amount' },
            { data: 'pay_mode', name: 'pay_mode' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
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