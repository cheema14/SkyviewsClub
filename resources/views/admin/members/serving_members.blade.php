@extends('layouts.admin')
@section('content')
@section('styles')
<style>
.dataTables_scrollBody, .dataTables_wrapper {
    position: static !important;
}
.dropdown-button {
    cursor: pointer;
    font-size: 2em;
    display:block
}
.dropdown-menu i {
    font-size: 1.33333333em;
    line-height: 0.75em;
    vertical-align: -15%;
    color: #000;
}
</style>
@endsection

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans('cruds.servingMember.title_plural') }} {{ trans('global.list') }}
                </h4>
            </div>
            @can('member_create')
            {{-- <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4 mr-2" href="{{ route('admin.members.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.member.title_singular') }}
                </a>
                @can('csv_import')
                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button>
                @endcan
                @include('csvImport.modal', ['model' => 'Member', 'route' => 'admin.members.parseCsvImport'])
            </div> --}}
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Member">
            <thead>
                <tr>

                    <th>
                        {{ trans('cruds.member.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.member.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.servingMember.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.servingMember.fields.service_type') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.member.fields.husband_father_name') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.member.fields.arrears') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.member.fields.membership_status') }}
                    </th> --}}
                    {{-- <th>
                        Actions
                    </th> --}}
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
@can('member_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.members.massDestroy') }}",
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

@can('dependent_list')
    // let listButtonTrans = '{{ trans('cruds.dependent.fields.list_dependent') }}';
    // let listButton = {
    //     text: listButtonTrans,
    //     url: "{{ route('admin.members.massDestroy') }}",
    //     className: 'btn-info',
    // }
    // dtButtons.push(listButton)
@endcan


  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.members.loadServingMembers') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'membership_no', name: 'membership_no' },
    { data: 'serving_officer_type', name: 'serving_officer_type', searchable: true },
    // { data: 'husband_father_name', name: 'husband_father_name' },
    // { data: 'arrears', name: 'arrears' },
    // { data: 'membership_status', name: 'membership_status' },
    // { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    createdRow: (row, data, dataIndex, cells) => {
        $(cells[6]).css('background-color', data.status_color)
    },
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Member').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
