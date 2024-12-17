@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@can('sports_billing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sports-billings.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.sportsBilling.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.sportsBilling.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SportsBilling">
                <thead>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.membership_no') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.non_member_name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_date') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_number') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.items') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.total_payable') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.net_pay') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.pay_mode') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsBilling.fields.remarks') }}
                        </th>
                        <th>
                            {{  trans(tenant()->id.'/global.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sportsBillings as $key => $sportsBilling)
                        <tr data-entry-id="{{ $sportsBilling->id }}">
                            {{-- <td>

                            </td> --}}
                            <td>
                                {{ $sportsBilling->id ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->member_name ?? '' }}
                            </td>
                            <td>
                                @foreach($sportsBilling->sportsBill as $bill)
                                    {{ $bill->membership_no }}
                                @endforeach
                                </td>
                            <td>
                                {{ $sportsBilling->non_member_name ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->bill_date ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->bill_number ?? '' }}
                            </td>
                            <td>
                                @foreach ($sportsBilling->sportBillingSportBillingItems as $item)
                                    <span class="badge badge-info">{{ $item->billing_item_name->item_name ?? '' }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $sportsBilling->total_payable ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->net_pay ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\SportsBilling::PAY_MODE_SELECT[$sportsBilling->pay_mode] ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->remarks ?? '' }}
                            </td>
                            <td>
                                @can('sports_billing_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sports-billings.show', $sportsBilling->id) }}">
                                        {{ trans(tenant()->id.'/global.view') }}
                                    </a>
                                @endcan

                                @can('sports_billing_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sports-billings.edit', $sportsBilling->id) }}">
                                        {{ trans(tenant()->id.'/global.edit') }}
                                    </a>
                                @endcan

                                @can('sports_billing_delete')
                                    <form action="{{ route('admin.sports-billings.destroy', $sportsBilling->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans(tenant()->id.'/global.delete') }}">
                                    </form>
                                @endcan
                                
                                <a target="_blank" class="btn btn-xs btn-success" href="{{ route('admin.sports-billings.printBill', $sportsBilling->id) }}">
                                    {{ trans(tenant()->id.'/global.datatables.print') }}
                                </a>


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
@can('sports_billing_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sports-billings.massDestroy') }}",
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
    // order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-SportsBilling:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection