@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<!-- @can('department_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.departments.create') }}">
            {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.department.title_singular') }}
            </a>
            @can('csv_import')
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans(tenant()->id.'/global.app_csvImport') }}
            </button>
            @endcan
            @include('csvImport.modal', ['model' => 'Department', 'route' => 'admin.departments.parseCsvImport'])
        </div>
    </div>
@endcan -->
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.department.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('department_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4 mr-2" href="{{ route('admin.departments.create') }}">
                    {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.department.title_singular') }}
                </a>
                @can('csv_import')
                <button class="btn btn-outline-info" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans(tenant()->id.'/global.app_csvImport') }}
                </button>
                @endcan
                @include('csvImport.modal', ['model' => 'Department', 'route' => 'admin.departments.parseCsvImport'])
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-borderless table-striped table-hover datatable datatable-Department">
                <thead>
                    <tr>

                        <th>
                            {{ trans(tenant()->id.'/cruds.department.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.department.fields.name') }}
                        </th>
                        <th class="text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $key => $department)
                        <tr data-entry-id="{{ $department->id }}">

                            <td>
                                {{ $department->id ?? '' }}
                            </td>
                            <td>
                                {{ $department->name ?? '' }}
                            </td>
                            <td class="text-center">

                                @can('department_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.departments.edit', $department->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('department_delete')
                                    <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
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
@can('department_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.departments.massDestroy') }}",
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
  let table = $('.datatable-Department:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
