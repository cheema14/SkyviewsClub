@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-info" href="{{ route('admin.good-receipts.index') }}">
        {{ trans('cruds.grItemDetail.back_to_good_receipt_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.grItemDetail.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gr-item-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $grItemDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.gr') }}
                        </th>
                        <td>
                            {{ $grItemDetail->gr->gr_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.item') }}
                        </th>
                        <td>
                            {{ $grItemDetail->item->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.unit') }}
                        </th>
                        <td>
                            {{ $grItemDetail->unit->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.quantity') }}
                        </th>
                        <td>
                            {{ $grItemDetail->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.unit_rate') }}
                        </th>
                        <td>
                            {{ $grItemDetail->unit_rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.total_amount') }}
                        </th>
                        <td>
                            {{ $grItemDetail->total_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.expiry_date') }}
                        </th>
                        <td>
                            {{ $grItemDetail->expiry_date }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.grItemDetail.fields.purchase_date') }}
                        </th>
                        <td>
                            {{ $grItemDetail->purchase_date }}
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gr-item-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>



@endsection