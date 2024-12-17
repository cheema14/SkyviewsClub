@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<!-- @can('store_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.store-items.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.storeItem.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.storeItem.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('store_item_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4 mr-2"   href="{{ route('admin.store-items.create') }}">
                    {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.storeItem.title_singular') }}
                </a>
            </div>
            @endcan
        </div>

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-borderless table-striped table-hover datatable datatable-StoreItem">
                <thead>
                    <tr>

                        <th>
                            {{ trans(tenant()->id.'/cruds.storeItem.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.storeItem.fields.name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.storeItem.fields.store') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.storeItem.fields.item') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.storeItem.fields.item_class') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.storeItem.fields.unit') }}
                        </th>
                        <th class="text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($storeItems as $key => $storeItem)
                        <tr data-entry-id="{{ $storeItem->id }}">

                            <td>
                                {{ $storeItem->id ?? '' }}
                            </td>
                            <td>
                                {{ $storeItem->name ?? '' }}
                            </td>
                            <td>
                                {{ $storeItem->store->name ?? '' }}
                            </td>
                            <td>
                                {{ $storeItem->item->type ?? '' }}
                            </td>
                            <td>
                                {{ $storeItem->item_class->name ?? '' }}
                            </td>
                            <td>
                                {{ $storeItem->unit->type ?? '' }}
                            </td>
                            <td class="text-center">

                                @can('store_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.store-items.edit', $storeItem->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('store_item_delete')
                                    <form action="{{ route('admin.store-items.destroy', $storeItem->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('store_item_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.store-items.massDestroy') }}",
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
    order: [[ 0, 'desc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-StoreItem:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
