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
    .dot {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }
</style>
@endsection
<!-- @can('order_create')
    <div style="margin-bottom: 10px;" class="row">
        @can('order_create')
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.orders.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
                </a>
            </div>

        @endcan
    </div>
@endcan -->

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="form-group col-md-4">
                <label for="from_date">From:</label>
                <input type="text" name="from_date" id="from_date" class="form-control from_date" required>
            </div>
        
            <div class="form-group col-md-4">
                <label for="to_date">To:</label>
                <input type="text" name="to_date" id="to_date" class="form-control to_date" value="">
            </div>

            @if (!request()->has('status'))
                <div class="form-group col-md-4">
                    <label>{{ trans('cruds.order.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('orderStatus') ? 'is-invalid' : '' }}" name="orderStatus" id="orderStatus">
                        <option value disabled {{ old('orderStatus', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                            @if ($key != 'Paid' && $key != 'Delivered' && $key !='Returned' && $key !='Complete')
                                <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group col-md-12">
                <button type="button" class="btn btn-primary" id="search">Search</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Order">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.order.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.tableTop.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.member') }}
                    </th>
                    <th>
                        {{ trans('cruds.member.fields.membership_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.member.fields.cell_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.status') }}
                    </th>
                     <th>
                        {{ trans('cruds.order.fields.created_at') }}
                    </th>
                    {{--<th>
                        {{ trans('cruds.order.fields.sub_total') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.tax') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.order.fields.total') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.order.fields.promo') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.order.fields.discount') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.order.fields.grand_total') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.item') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.floors.title_singular') }}
                    </th> --}}
                    <th>
                        Actions
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('order_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.orders.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')

                return
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: config.url,
                data: { ids: ids, _method: 'DELETE' }})
                .done(function () { location.reload() })
            }
            }
        }
        dtButtons.push(deleteButton)
    @endcan
        var status = @json(request()->status ?? '');
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            // ajax: "{{ route('admin.orders.index',['status' => '"status"']) }}",
            ajax: {
                url: "{{ route('admin.orders.index') }}",
                type: "GET",
                data: function (d) {
                    d.status = status;
                },
                // ... other ajax options
            },
            // ... other ajax options
            columns:[
                    { data: 'id', name: 'id' },
                    { data: 'table_top.code', name: 'tableTop.code' },
                    { data: 'user_name', name: 'user.name' },
                    { data: 'member_name', name: 'member.name' },
                    { data: 'member.membership_no', name: 'member.membership_no' },
                    { data: 'member.cell_no', name: 'member.cell_no' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    // { data: 'sub_total', name: 'sub_total' },
                    // { data: 'tax', name: 'tax' },
                    { data: 'total', name: 'total' },
                    // { data: 'promo', name: 'promo' },
                    // { data: 'discount', name: 'discount' },
                    { data: 'grand_total', name: 'grand_total' },
                    { data: 'item', name: 'items.title' },
                    // { data: 'floor', name: 'floor' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            createdRow: (row, data, dataIndex, cells) => {
                $(cells[6]).html('<span style="background-color:'+data.status_color+'" class="dot"></span>'+data.status);
            },
            orderCellsTop: true,
            order: [[ 0, 'desc' ]],
            pageLength: 10,
        },
        table = $('.datatable-Order').DataTable(dtOverrideGlobals);

    $(document).on("click","#search",function(){
        let selectedStatus = 'all';
        
        // Get the selected status value
        if($("#orderStatus").val()){
            selectedStatus = $("#orderStatus").val();
        }
        
        
        
        let fromDate = $("#from_date").val();
        let toDate = $("#to_date").val();
        
        // Clear the DataTable
        table.clear().draw();
        table.ajax.url("{{ route('admin.orders.index') }}?fromDate="+fromDate+"&toDate="+toDate+"&orderStatus="+selectedStatus).load();
    
    });

    $(document).on("click","#reset",function(){
        reset_form_fields();
        table.clear().draw();
        table.ajax.url("{{ route('admin.orders.index') }}").load();
    });

    function reset_form_fields() {
        $("#orderStatus").val('');
        $("#from_date").val('');
        // $("#to_date").val('');
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

});


$(document).on("click", ".performAction",function(e) {

    setTimeout(function () {
        location.reload(true);
    }, 1000);
});
</script>


<script type="text/javascript">

    setInterval('refreshPage()', 300000);

    function refreshPage() {
        location.reload();
    }
</script>
@endsection
