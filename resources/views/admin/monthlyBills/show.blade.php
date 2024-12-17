@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.monthlyBill.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monthly-bills.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.id') }}
                        </th>
                        <td>
                            {{ $monthlyBill->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.bill_date') }}
                        </th>
                        <td>
                            {{ $monthlyBill->bill_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.membership_no') }}
                        </th>
                        <td>
                            {{ $monthlyBill->membership_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.billing_amount') }}
                        </th>
                        <td>
                            {{ $monthlyBill->billing_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBill.fields.status') }}
                        </th>
                        <td>
                            {{ $monthlyBill->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                {{-- <a class="btn btn-default" href="{{ route('admin.monthly-bills.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a> --}}
            </div>
        </div>
    </div>
</div>



@endsection