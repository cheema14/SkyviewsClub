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
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.paymentHistory.title') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Payment-Receipts">
            <thead>
                <tr>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.name') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.membership_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.cnic') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.father_husband_name') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.membership_status') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.invoice_month') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.total_invoice') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.paid_amount') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.paymentHistory.fields.balance') }}
                    </th>
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
            ajax: "{{ route('admin.paymentHistory.view-payment-history-list') }}",
            columns: [
                { data: 'member_id', name: 'member_id' },
                { data: 'member_name', name: 'member_name' },
                { data: 'membership_no', name: 'membership_no' },
                { data: 'cnic_no', name: 'cnic_no' },
                { data: 'husband_father_name', name: 'husband_father_name' },
                { data: 'membership_status', name: 'membership_status' },
                { data: 'billing_month', name: 'billing_month' },
                { data: 'invoice_amount', name: 'invoice_amount' },
                { data: 'totalPaid', name: 'totalPaid' },
                { data: 'arrears', name: 'arrears' },
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