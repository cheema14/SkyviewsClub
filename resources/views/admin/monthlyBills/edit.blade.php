@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.edit') }} {{ trans(tenant()->id.'/cruds.monthlyBill.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.monthly-bills.update", [$monthlyBill->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="bill_date">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.bill_date') }}</label>
                <input class="form-control date {{ $errors->has('bill_date') ? 'is-invalid' : '' }}" type="text" name="bill_date" id="bill_date" value="{{ old('bill_date', $monthlyBill->bill_date) }}" required>
                @if($errors->has('bill_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.bill_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="membership_no">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.membership_no') }}</label>
                <input class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" type="text" name="membership_no" id="membership_no" value="{{ old('membership_no', $monthlyBill->membership_no) }}" required>
                @if($errors->has('membership_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('membership_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.membership_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="billing_amount">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.billing_amount') }}</label>
                <input class="form-control {{ $errors->has('billing_amount') ? 'is-invalid' : '' }}" type="number" name="billing_amount" id="billing_amount" value="{{ old('billing_amount', $monthlyBill->billing_amount) }}" step="1" max="200000" required>
                @if($errors->has('billing_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.billing_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.status') }}</label>
                <select class="form-control" name="status">
                    <option disabled> Select Billing Status</option>
                    <option value="Paid" {{ $monthlyBill->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Unpaid" {{ $monthlyBill->status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection