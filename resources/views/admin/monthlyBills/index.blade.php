@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@can('monthly_bill_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.monthly-bills.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.monthlyBill.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.monthlyBill.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-MonthlyBill">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.bill_date') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.membership_no') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.billing_amount') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyBills as $key => $monthlyBill)
                        <tr data-entry-id="{{ $monthlyBill->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $monthlyBill->id ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyBill->bill_date ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyBill->membership_no ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyBill->billing_amount ?? '' }}
                            </td>
                            <td>
                                @if ($monthlyBill->status == 'Paid')
                                    <span style="cursor: default;" class="btn btn-xs btn-success">{{ $monthlyBill->status }}</span>
                                @elseif ($monthlyBill->status == 'Unpaid')
                                    <span style="cursor: default;" class="btn btn-xs btn-warning">{{ $monthlyBill->status }}</span>
                                @elseif ($monthlyBill->status == App\Models\MonthlyBill::STATUS_SELECT["ADDED"])
                                    <span style="cursor: default;" class="btn btn-xs btn-primary">{{ $monthlyBill->status }}</span>
                                @else
                                    <span style="cursor: default;" class="btn btn-xs btn-primary">{{ 'N/A' }}</span>
                                @endif

                                
                            </td>
                            <td>
                                @can('monthly_bill_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.monthly-bills.show', $monthlyBill->id) }}">
                                        <!-- {{ trans(tenant()->id.'/global.view') }} -->
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                @endcan

                                @can('monthly_bill_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.monthly-bills.edit', $monthlyBill->id) }}">
                                        <!-- {{ trans(tenant()->id.'/global.edit') }} -->
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                @endcan

                                @can('monthly_bill_delete')
                                    <form action="{{ route('admin.monthly-bills.destroy', $monthlyBill->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger" value="{{ trans(tenant()->id.'/global.delete') }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
@can('monthly_bill_delete')
  let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.monthly-bills.massDestroy') }}",
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
    pageLength: 25,
  });
  let table = $('.datatable-MonthlyBill:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection