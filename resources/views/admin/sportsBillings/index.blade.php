@extends('layouts.admin')
@section('content')
@can('sports_billing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sports-billings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sportsBilling.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.sportsBilling.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SportsBilling">
                <thead>
                    <tr>
                        {{-- <th width="10">

                        </th> --}}
                        <th>
                            {{ trans('cruds.sportsBilling.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.member_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.non_member_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.bill_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.bill_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.remarks') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.sportsBilling.fields.ref_club') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.club_id_ref') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.tee_off') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.holes') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.caddy') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.temp_mbr') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.temp_caddy') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.sportsBilling.fields.pay_mode') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.sportsBilling.fields.gross_total') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.sportsBilling.fields.total_payable') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.bank_charges') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportsBilling.fields.net_pay') }}
                        </th>
                        <th>
                            {{  trans('global.actions') }}
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
                                {{ $sportsBilling->non_member_name ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->bill_date ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->bill_number ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->remarks ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $sportsBilling->ref_club ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->club_id_ref ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->tee_off ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->holes ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->caddy ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->temp_mbr ?? '' }}
                            </td>
                            <td>
                                {{ $sportsBilling->temp_caddy ?? '' }}
                            </td> --}}
                            <td>
                                {{ App\Models\SportsBilling::PAY_MODE_SELECT[$sportsBilling->pay_mode] ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $sportsBilling->gross_total ?? '' }}
                            </td> --}}
                            <td>
                                {{ $sportsBilling->total_payable ?? '' }}
                            </td>
                            @if ($sportsBilling->pay_mode == 'card')
                                <td>
                                    {{ $sportsBilling->bank_charges ?? '' }}
                                </td> 
                            @else
                                <td>
                                    N/A
                                </td> 
                            @endif
                            <td>
                                {{ $sportsBilling->net_pay ?? '' }}
                            </td>
                            <td>
                                @can('sports_billing_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sports-billings.show', $sportsBilling->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sports_billing_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sports-billings.edit', $sportsBilling->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sports_billing_delete')
                                    <form action="{{ route('admin.sports-billings.destroy', $sportsBilling->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                                
                                <a target="_blank" class="btn btn-xs btn-success" href="{{ route('admin.sports-billings.printBill', $sportsBilling->id) }}">
                                    {{ trans('global.datatables.print') }}
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
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sports-billings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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