@extends('layouts.admin')
@section('content')
@include('partials.flash_messages')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                    {{ trans('cruds.designation.title_singular') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('designation_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4 mr-2" href="{{ route('admin.designations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.designation.title_singular') }}
                </a>
                @can('csv_import')
                <button class="btn btn-outline-info" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @endcan
                @include('csvImport.modal', ['model' => 'Designation', 'route' => 'admin.designations.parseCsvImport'])
            </div>
            @endcan
        </div>
        
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-borderless table-striped table-hover datatable datatable-Designation">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.title') }}
                        </th>
                        <th class="text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designations as $key => $designation)
                        <tr data-entry-id="{{ $designation->id }}">
                            <td>
                                {{ $designation->id ?? '' }}
                            </td>
                            <td>
                                {{ $designation->title ?? '' }}
                            </td>
                            <td class="text-center">

                                @can('designation_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.designations.edit', $designation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('designation_delete')
                                    <form action="{{ route('admin.designations.destroy', $designation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('designation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.designations.massDestroy') }}",
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
  let table = $('.datatable-Designation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
