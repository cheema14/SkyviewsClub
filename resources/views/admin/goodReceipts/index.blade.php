@extends('layouts.'.tenant()->id.'/admin')
@section('content')
<!-- @can('good_receipt_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.good-receipts.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.goodReceipt.title_singular') }}
            </a>
        </div>
    </div>
@endcan -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.goodReceipt.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('good_receipt_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4" href="{{ route('admin.good-receipts.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.goodReceipt.title_singular') }}
                </a>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-GoodReceipt">
            <thead>
                <tr>
                    {{-- <th width="10">

                    </th> --}}
                    <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_number') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.store') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_date') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.vendor') }}
                    </th>
                    {{-- <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.pay_type') }}
                    </th> --}}
                    <th>
                        {{ trans(tenant()->id.'/cruds.goodReceipt.fields.remarks') }}
                    </th>
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
@can('good_receipt_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.good-receipts.massDestroy') }}",
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
    ajax: "{{ route('admin.good-receipts.index') }}",
    columns: [
    //   { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'gr_number', name: 'gr_number' },
{ data: 'store_name', name: 'store.name' },
{ data: 'gr_date', name: 'gr_date' },
{ data: 'vendor_name', name: 'vendor.name' },
// { data: 'pay_type', name: 'pay_type' },
{ data: 'remarks', name: 'remarks' },
{ data: 'actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-GoodReceipt').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
