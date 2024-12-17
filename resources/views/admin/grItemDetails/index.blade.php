@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<!-- @can('gr_item_detail_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.gr-item-details.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.grItemDetail.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.grItemDetail.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('gr_item_detail_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.gr-item-details.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.grItemDetail.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-GrItemDetail">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
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
                       Actions
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
@can('gr_item_detail_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.gr-item-details.massDestroy') }}",
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.gr-item-details.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'gr_gr_number', name: 'gr.gr_number' },
{ data: 'item_name', name: 'item.name' },
{ data: 'unit_type', name: 'unit.type' },
{ data: 'quantity', name: 'quantity' },
{ data: 'unit_rate', name: 'unit_rate' },
{ data: 'total_amount', name: 'total_amount' },
{ data: 'expiry_date', name: 'expiry_date' },
// { data: 'purchase_date', name: 'purchase_date' },
{ data: 'actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-GrItemDetail').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
