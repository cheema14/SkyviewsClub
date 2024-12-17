@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<!-- @can('item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.items.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.item.title_singular') }}
            </a>
            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans(tenant()->id.'/global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Item', 'route' => 'admin.items.parseCsvImport']) --}}
        </div>
    </div>
@endcan -->
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.item.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('item_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.items.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.item.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Item">
            <thead>
                <tr>

                    <th>
                        {{ trans(tenant()->id.'/cruds.item.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.item.fields.title') }}
                    </th>
                    {{-- <th>
                        {{ trans(tenant()->id.'/cruds.item.fields.menu') }}
                    </th> --}}
                    <th>
                        {{ trans(tenant()->id.'/cruds.item.fields.menu_item_category') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.item.fields.summary') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.item.fields.price') }}
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
@can('item_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.items.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.items.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'title', name: 'title' },
// { data: 'menu', name: 'menus.title' },
{ data: 'menu_item_category_name', name: 'menu_item_category.name' },
{ data: 'summary', name: 'summary' },
{ data: 'price', name: 'price' },
{ data: 'actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Item').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
