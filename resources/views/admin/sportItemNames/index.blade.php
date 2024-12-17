@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@can('sport_item_name_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sport-item-names.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.sportItemName.title_singular') }}
            </a>
        </div>
    </div>
@endcan
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.sportItemName.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SportItemName">
                <thead>
                    <tr>
                        {{-- <th width="10">

                        </th> --}}
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.item_name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.item_class') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.item_rate') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.unit') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/global.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sportItemNames as $key => $sportItemName)
                        <tr data-entry-id="{{ $sportItemName->id }}">
                            {{-- <td>

                            </td> --}}
                            <td>
                                {{ $sportItemName->id ?? '' }}
                            </td>
                            <td>
                                {{ $sportItemName->item_name ?? '' }}
                            </td>
                            <td>
                                {{ $sportItemName->item_class->item_class ?? '' }}
                            </td>
                            <td>
                                {{ $sportItemName->item_rate ?? '' }}
                            </td>
                            <td>
                                {{ $sportItemName->unit ?? '' }}
                            </td>
                            <td>
                                @can('sport_item_name_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sport-item-names.show', $sportItemName->id) }}">
                                        {{ trans(tenant()->id.'/global.view') }}
                                    </a>
                                @endcan

                                @can('sport_item_name_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sport-item-names.edit', $sportItemName->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('sport_item_name_delete')
                                    <form action="{{ route('admin.sport-item-names.destroy', $sportItemName->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
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
@can('sport_item_name_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sport-item-names.massDestroy') }}",
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
  let table = $('.datatable-SportItemName:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection