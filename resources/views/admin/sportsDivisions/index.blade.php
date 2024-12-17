@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@can('sports_division_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sports-divisions.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.sportsDivision.title_singular') }}
            </a>
        </div>
    </div>
@endcan
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.sportsDivision.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SportsDivision">
                <thead>
                    <tr>
                        {{-- <th width="10">

                        </th> --}}
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsDivision.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsDivision.fields.division') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/global.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sportsDivisions as $key => $sportsDivision)
                        <tr data-entry-id="{{ $sportsDivision->id }}">
                            {{-- <td>

                            </td> --}}
                            <td>
                                {{ $sportsDivision->id ?? '' }}
                            </td>
                            <td>
                                {{ $sportsDivision->division ?? '' }}
                            </td>
                            <td>
                                @can('sports_division_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sports-divisions.show', $sportsDivision->id) }}">
                                        {{ trans(tenant()->id.'/global.view') }}
                                    </a>
                                @endcan

                                @can('sports_division_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sports-divisions.edit', $sportsDivision->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('sports_division_delete')
                                    <form action="{{ route('admin.sports-divisions.destroy', $sportsDivision->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
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
@can('sports_division_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sports-divisions.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-SportsDivision:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection