@extends('layouts.admin')
@section('content')
<!-- @can('stock_issue_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.stock-issue-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.stockIssueItem.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.stockIssueItem.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('stock_issue_item_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.stock-issue-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.stockIssueItem.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-StockIssueItem">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.stockIssueItem.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssueItem.fields.item') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssueItem.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssueItem.fields.lot_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssueItem.fields.stock_required') }}
                    </th>
                    <th>
                        {{ trans('cruds.stockIssueItem.fields.issued_qty') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.stockIssueItem.fields.stock_issue') }}
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
@can('stock_issue_item_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.stock-issue-items.massDestroy') }}",
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
    ajax: "{{ route('admin.stock-issue-items.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'item_name', name: 'item.name' },
{ data: 'unit_type', name: 'unit.type' },
{ data: 'lot_no', name: 'lot_no' },
{ data: 'stock_required', name: 'stock_required' },
{ data: 'issued_qty', name: 'issued_qty' },
// { data: 'stock_issue_issue_no', name: 'stock_issue_id' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-StockIssueItem').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
