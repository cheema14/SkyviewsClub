@extends('layouts.admin')
@section('content')
<!-- @can('transaction_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.transactions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.transaction.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.transaction.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('transaction_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.transactions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.transaction.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Transaction">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.transaction.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.order') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.order_id') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.grand_total') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.transaction.fields.code') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.transaction.fields.type') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.transaction.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
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
@can('transaction_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.transactions.massDestroy') }}",
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.transactions.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
    { data: 'id', name: 'id' },
    { data: 'user_name', name: 'user.name' },
    { data: 'order_status', name: 'order.status' },
    { data: 'order_id', name: 'order.id' },
    { data: 'order.grand_total', name: 'order.grand_total' },
    // { data: 'code', name: 'code' },
    // { data: 'type', name: 'type' },
    { data: 'status', name: 'status' },
    { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Transaction').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
