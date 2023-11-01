@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sportBillingItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-billing-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.id') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_division') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->billing_division->division ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_item_type') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->billing_item_type->item_type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_item_class') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->billing_item_class->item_class ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_item_name') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->billing_item_name->item_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.quantity') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.rate') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.amount') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportBillingItem.fields.billing_issue_item') }}
                        </th>
                        <td>
                            {{ $sportBillingItem->billing_issue_item->member_name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-billing-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection