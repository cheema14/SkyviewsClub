@extends('layouts.admin')
@section('content')
<!-- @can('stock_issue_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.stock-issues.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.stockIssue.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.stockIssue.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('stock_issue_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.stock-issues.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.stockIssue.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-StockIssue">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.stockIssue.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssue.fields.issue_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssue.fields.issue_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssue.fields.section') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssue.fields.store') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssue.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssue.fields.remarks') }}
                    </th>
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
@can('stock_issue_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.stock-issues.massDestroy') }}",
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
    ajax: "{{ route('admin.stock-issues.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'issue_no', name: 'issue_no' },
{ data: 'issue_date', name: 'issue_date' },
{ data: 'section_name', name: 'section.name' },
{ data: 'store_name', name: 'store.name' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'remarks', name: 'remarks' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-StockIssue').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
