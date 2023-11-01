@extends('layouts.admin')
@section('content')
@can('sport_billing_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sport-billing-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sportBillingItem.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.sportBillingItem.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SportBillingItem">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_division') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_item_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_item_class') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_item_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.rate') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_issue_item') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sportBillingItems as $key => $sportBillingItem)
                        <tr data-entry-id="{{ $sportBillingItem->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $sportBillingItem->id ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->billing_division->division ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->billing_item_type->item_type ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->billing_item_class->item_class ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->billing_item_name->item_name ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->quantity ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->rate ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->amount ?? '' }}
                            </td>
                            <td>
                                {{ $sportBillingItem->billing_issue_item->member_name ?? '' }}
                            </td>
                            <td>
                                @can('sport_billing_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sport-billing-items.show', $sportBillingItem->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sport_billing_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sport-billing-items.edit', $sportBillingItem->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sport_billing_item_delete')
                                    <form action="{{ route('admin.sport-billing-items.destroy', $sportBillingItem->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@can('sport_billing_item_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sport-billing-items.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-SportBillingItem:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection