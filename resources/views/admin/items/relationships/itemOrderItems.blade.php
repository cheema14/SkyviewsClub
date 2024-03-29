<!-- @can('order_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.order-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.orderItem.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.orderItem.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('order_item_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.order-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.orderItem.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-itemOrderItems">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.order') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.grand_total') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.item') }}
                        </th>
                        <th>
                            {{ trans('cruds.item.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.discount') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderItem.fields.content') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $key => $orderItem)
                        <tr data-entry-id="{{ $orderItem->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $orderItem->id ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->order->status ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->order->grand_total ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->item->title ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->item->price ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->price ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->discount ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->quantity ?? '' }}
                            </td>
                            <td>
                                {{ $orderItem->content ?? '' }}
                            </td>
                            <td>
                                @can('order_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.order-items.show', $orderItem->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('order_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.order-items.edit', $orderItem->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('order_item_delete')
                                    <form action="{{ route('admin.order-items.destroy', $orderItem->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@can('order_item_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.order-items.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-itemOrderItems:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection