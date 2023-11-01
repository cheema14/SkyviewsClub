@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.goodReceipt.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.good-receipts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.id') }}
                        </th>
                        <td>
                            {{ $goodReceipt->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.gr_number') }}
                        </th>
                        <td>
                            {{ $goodReceipt->gr_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.store') }}
                        </th>
                        <td>
                            {{ $goodReceipt->store->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.gr_date') }}
                        </th>
                        <td>
                            {{ $goodReceipt->gr_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.vendor') }}
                        </th>
                        <td>
                            {{ $goodReceipt->vendor->name ?? '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.pay_type') }}
                        </th>
                        <td>
                            {{ App\Models\GoodReceipt::PAY_TYPE_SELECT[$goodReceipt->pay_type] ?? '' }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.gr_bill_no') }}
                        </th>
                        <td>
                            {{ $goodReceipt->gr_bill_no ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.goodReceipt.fields.remarks') }}
                        </th>
                        <td>
                            {{ $goodReceipt->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.good-receipts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.relatedData') }}</h4>
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#gr_gr_item_details" role="tab" data-toggle="tab">
                {{ trans('cruds.grItemDetail.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="gr_gr_item_details">
            @includeIf('admin.goodReceipts.relationships.grGrItemDetails', ['grItemDetails' => $goodReceipt->grGrItemDetails])
        </div>
    </div>
</div>

@endsection
