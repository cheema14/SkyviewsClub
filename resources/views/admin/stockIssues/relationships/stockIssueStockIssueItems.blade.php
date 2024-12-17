<!-- @can('stock_issue_item_create')
    <div style="margin-bottom: 10px;display:none !important;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.stock-issue-items.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.stockIssueItem.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{-- {{ trans(tenant()->id.'/cruds.stockIssueItem.title_singular') }} {{ trans(tenant()->id.'/global.list') }} --}}
                </h4>
            </div>
            @can('stock_issue_item_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.stock-issue-items.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.stockIssueItem.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-borderless table-striped table-hover datatable datatable-stockIssueStockIssueItems">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.item') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.unit') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.lot_no') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.stock_required') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.issued_qty') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.stock_issue') }}
                        </th>
                        {{-- <th class="text-center">
                            Actions
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockIssueItems as $key => $stockIssueItem)
                        <tr data-entry-id="{{ $stockIssueItem->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $stockIssueItem->id ?? '' }}
                            </td>
                            <td>
                                {{ $stockIssueItem->item->name ?? '' }}
                            </td>
                            <td>
                                {{ $stockIssueItem->unit->type ?? '' }}
                            </td>
                            <td>
                                {{ $stockIssueItem->lot_no ?? '' }}
                            </td>
                            <td>
                                {{ $stockIssueItem->stock_required ?? '' }}
                            </td>
                            <td>
                                {{ $stockIssueItem->issued_qty ?? '' }}
                            </td>
                            <td>
                                {{ $stockIssueItem->stock_issue->issue_no ?? '' }}
                            </td>
                            <td class="text-center">
                                @can('stock_issue_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.stock-issue-items.show', $stockIssueItem->id) }}">
                                        {{ trans(tenant()->id.'/global.view') }}
                                    </a>
                                @endcan

                                @can('stock_issue_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.stock-issue-items.edit', $stockIssueItem->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('stock_issue_item_delete')
                                    <form action="{{ route('admin.stock-issue-items.destroy', $stockIssueItem->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans(tenant()->id.'/global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('stock_issue_item_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.stock-issue-items.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans(tenant()->id.'/global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans(tenant()->id.'/global.areYouSure') }}')) {
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-stockIssueStockIssueItems:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
