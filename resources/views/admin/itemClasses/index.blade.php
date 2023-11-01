@extends('layouts.admin')
@section('content')
@can('item_class_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.item-classes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.itemClass.title_singular') }}
            </a>
            @can('csv_import')
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @endcan
            @include('csvImport.modal', ['model' => 'ItemClass', 'route' => 'admin.item-classes.parseCsvImport'])
        </div>
    </div>
@endcan
@include('partials.flash_messages')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.itemClass.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ItemClass">
                <thead>
                    <tr>

                        <th>
                            {{ trans('cruds.itemClass.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.itemClass.fields.item_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.itemClass.fields.name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itemClasses as $key => $itemClass)
                        <tr data-entry-id="{{ $itemClass->id }}">

                            <td>
                                {{ $itemClass->id ?? '' }}
                            </td>
                            <td>
                                {{ $itemClass->item_type->type ?? '' }}
                            </td>
                            <td>
                                {{ $itemClass->name ?? '' }}
                            </td>
                            <td>

                                @can('item_class_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.item-classes.edit', $itemClass->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('item_class_delete')
                                    <form action="{{ route('admin.item-classes.destroy', $itemClass->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('item_class_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.item-classes.massDestroy') }}",
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
    order: [[ 0, 'desc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-ItemClass:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
