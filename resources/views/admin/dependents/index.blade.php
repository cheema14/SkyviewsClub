@extends('layouts.admin')
@section('content')
@can('dependent_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Dependent', 'route' => 'admin.dependents.parseCsvImport']) --}}
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dependent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Dependent">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans('cruds.dependent.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.dob') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.relation') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.occupation') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.nationality') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.golf_hcap') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.allow_credit') }}
                    </th>
                    <th>
                        {{ trans('cruds.dependent.fields.photo') }}
                    </th>
                    <th>
                        &nbsp;
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
@can('dependent_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dependents.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
        // console.log("config",config);
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
    ajax: "",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'dob', name: 'dob' },
{ data: 'relation', name: 'relation' },
{ data: 'occupation', name: 'occupation' },
{ data: 'nationality', name: 'nationality' },
{ data: 'golf_hcap', name: 'golf_hcap' },
{ data: 'allow_credit', name: 'allow_credit' },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Dependent').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
