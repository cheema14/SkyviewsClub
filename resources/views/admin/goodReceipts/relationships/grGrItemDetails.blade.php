@can('gr_item_detail_create')
    <div style="margin-bottom: 10px;display:none !important;" class="row">
        <div class="col-lg-12">
            {{-- <a class="btn btn-success" href="{{ route('admin.gr-item-details.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.grItemDetail.title_singular') }}
            </a> --}}
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{-- {{ trans(tenant()->id.'/cruds.grItemDetail.title_singular') }} {{ trans(tenant()->id.'/global.list') }} --}}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-grGrItemDetails">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.gr') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.item') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.unit') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.unit_rate') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.total_amount') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.expiry_date') }}
                        </th>
                        {{-- <th>
                            {{ trans(tenant()->id.'/cruds.grItemDetail.fields.purchase_date') }}
                        </th> --}}
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grItemDetails as $key => $grItemDetail)
                        <tr data-entry-id="{{ $grItemDetail->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $grItemDetail->id ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->gr->gr_number ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->item->name ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->unit->type ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->quantity ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->unit_rate ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->total_amount ?? '' }}
                            </td>
                            <td>
                                {{ $grItemDetail->expiry_date ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $grItemDetail->purchase_date ?? '' }}
                            </td> --}}
                            <td>
                                @can('gr_item_detail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.gr-item-details.show', $grItemDetail->id) }}">
                                        {{ trans(tenant()->id.'/global.view') }}
                                    </a>
                                @endcan

                                @can('gr_item_detail_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.gr-item-details.edit', $grItemDetail->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('gr_item_detail_delete')
                                    <form action="{{ route('admin.gr-item-details.destroy', $grItemDetail->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('gr_item_detail_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.gr-item-details.massDestroy') }}",
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
  let table = $('.datatable-grGrItemDetails:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
