@extends('layouts.admin')
@section('content')
<!-- @can('table_top_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.table-tops.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.tableTop.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
@include('partials.flash_messages')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                    {{ trans('cruds.tableTop.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('table_top_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.table-tops.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.tableTop.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-TableTop">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.tableTop.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.tableTop.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.tableTop.fields.capacity') }}
                    </th>
                    <th>
                        {{ trans('cruds.tableTop.fields.status') }}
                    </th>
                    <th class="text-center">
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
@can('table_top_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.table-tops.massDestroy') }}",
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
    ajax: "{{ route('admin.table-tops.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'capacity', name: 'capacity' },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-TableTop').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
