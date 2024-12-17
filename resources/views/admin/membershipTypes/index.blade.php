@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<!-- @can('membership_type_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.membership-types.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.membershipType.title_singular') }}
            </a>
            @can('csv_import')
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans(tenant()->id.'/global.app_csvImport') }}
            </button>
            @endcan
            @include('csvImport.modal', ['model' => 'MembershipType', 'route' => 'admin.membership-types.parseCsvImport'])
        </div>
    </div>
@endcan -->
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.membershipType.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('membership_type_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4 mr-2" href="{{ route('admin.membership-types.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.membershipType.title_singular') }}
                </a>
                @can('csv_import')
                <button class="btn btn-outline-info" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans(tenant()->id.'/global.app_csvImport') }}
                </button>
                @endcan
                @include('csvImport.modal', ['model' => 'MembershipType', 'route' => 'admin.membership-types.parseCsvImport'])
            </div>
            @endcan
        </div>
        
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-borderless table-striped table-hover datatable datatable-MembershipType">
                <thead>
                    <tr>

                        <th>
                            {{ trans(tenant()->id .'/cruds.membershipType.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id .'/cruds.membershipType.fields.name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id .'/cruds.membershipType.fields.effective_from') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id .'/cruds.membershipType.fields.subscription_fee') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id .'/cruds.membershipType.fields.security_fee') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id .'/cruds.membershipType.fields.monthly_fee') }}
                        </th>
                        <th class="text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($membershipTypes as $key => $membershipType)
                        <tr data-entry-id="{{ $membershipType->id }}">

                            <td>
                                {{ $membershipType->id ?? '' }}
                            </td>
                            <td>
                                {{ $membershipType->name ?? '' }}
                            </td>
                            <td>
                                {{ $membershipType->effective_from ?? '' }}
                            </td>
                            <td>
                                {{ $membershipType->subscription_fee ?? '' }}
                            </td>
                            <td>
                                {{ $membershipType->security_fee ?? '' }}
                            </td>
                            <td>
                                {{ $membershipType->monthly_fee ?? '' }}
                            </td>
                            <td class="text-center">

                                @can('membership_type_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.membership-types.edit', $membershipType->id) }}">
                                        {{ trans(tenant()->id .'/global.edit') }}
                                    </a>
                                @endcan

                                @can('membership_type_delete')
                                    <form action="{{ route('admin.membership-types.destroy', $membershipType->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id .'/global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans(tenant()->id .'/global.delete') }}">
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
@can('membership_type_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id .'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.membership-types.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans(tenant()->id .'/global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans(tenant()->id .'/global.areYouSure') }}')) {
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
  let table = $('.datatable-MembershipType:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
