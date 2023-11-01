@extends('layouts.admin')
@section('content')
<!-- @can('menu_item_category_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.menu-item-categories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.menuItemCategory.title_singular') }}
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
                {{ trans('cruds.menuItemCategory.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('menu_item_category_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4"   href="{{ route('admin.menu-item-categories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.menuItemCategory.title_singular') }}
                </a>
            </div>
            @endcan
        </div>

    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-MenuItemCategory">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.menuItemCategory.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.menuItemCategory.fields.menu') }}
                    </th>
                    <th>
                        {{ trans('cruds.menuItemCategory.fields.name') }}
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
@can('menu_item_category_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.menu-item-categories.massDestroy') }}",
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
    ajax: "{{ route('admin.menu-item-categories.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'menu', name: 'menus.title' },
{ data: 'name', name: 'name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-MenuItemCategory').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
