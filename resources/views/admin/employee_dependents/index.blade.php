@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@can('dependent_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

            <a href="{{ route('admin.employees.index') }}" class="btn btn-warning">
                {{ trans(tenant()->id.'/global.back') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.dependent.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Dependent">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans(tenant()->id.'/cruds.dependent.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.dependent.fields.name') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.dependent.fields.dob') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.dependent.fields.relation') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.dependent.fields.occupation') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.dependent.fields.nationality') }}
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
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}';
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
    ajax: "",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'date_of_birth', name: 'date_of_birth' },
{ data: 'relation', name: 'relation' },
{ data: 'profession', name: 'profession' },
{ data: 'nationality', name: 'nationality' },
{ data: 'actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
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
