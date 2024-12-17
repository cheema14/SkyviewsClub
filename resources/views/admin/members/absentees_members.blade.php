@extends('layouts.'.tenant()->id.'.admin')
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
                {{ trans(tenant()->id.'/cruds.member.absentees_member') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('member_create')
            {{-- <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4 mr-2" href="{{ route('admin.members.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.member.title_singular') }}
                </a>
                @can('csv_import')
                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans(tenant()->id.'/global.app_csvImport') }}
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
                        {{ trans(tenant()->id.'/cruds.member.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.name') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.membership_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.cnic_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.membership_status') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.membership_category') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.monthly_type') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.absentee_from_date') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.absentee_to_date') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.monthly_subscription_revised_title') }}
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
@can('member_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.members.massDestroy') }}",
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

@can('dependent_list')
    // let listButtonTrans = '{{ trans(tenant()->id.'/cruds.dependent.fields.list_dependent') }}';
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
    ajax: "{{ route('admin.members.loadAbsenteesMembers') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'membership_no', name: 'membership_no' },
    { data: 'cnic_no', name: 'cnic_no', searchable: true },
    { data: 'membership_status', name: 'membership_status' },
    { data: 'membership_category.name', name: 'membership_category.name', default:'N/A' },
    { data: 'monthly_type', name: 'monthly_type', default:'N/A' },
    { data: 'discounted_membership_fees.implemented_from', name: 'discounted_membership_fees.implemented_from', default:'N/A' },
    { data: 'discounted_membership_fees.implemented_from', name: 'discounted_membership_fees.implemented_from', default:'N/A' },
    { data: 'monthly_subscription_revised', name: 'monthly_subscription_revised', default:'N/A' },
    
    ],
    // createdRow: (row, data, dataIndex, cells) => {
    //     $(cells[6]).css('background-color', data.status_color)
    // },
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
