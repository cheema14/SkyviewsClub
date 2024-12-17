@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.edit') }} {{ trans(tenant()->id.'/cruds.goodReceipt.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.good-receipts.update", [$goodReceipt->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="gr_number">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_number') }}</label>
                <input class="form-control {{ $errors->has('gr_number') ? 'is-invalid' : '' }}" type="text" name="gr_number" id="gr_number" value="{{ old('gr_number', $goodReceipt->gr_number) }}" required>
                @if($errors->has('gr_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gr_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="store_id">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.store') }}</label>
                <select class="form-control select2 {{ $errors->has('store') ? 'is-invalid' : '' }}" name="store_id" id="store_id" required>
                    @foreach($stores as $id => $entry)
                        <option value="{{ $id }}" {{ (old('store_id') ? old('store_id') : $goodReceipt->store->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('store'))
                    <div class="invalid-feedback">
                        {{ $errors->first('store') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.store_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gr_date">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_date') }}</label>
                <input class="form-control date {{ $errors->has('gr_date') ? 'is-invalid' : '' }}" type="text" name="gr_date" id="gr_date" value="{{ old('gr_date', $goodReceipt->gr_date) }}" required>
                @if($errors->has('gr_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gr_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vendor_id">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.vendor') }}</label>
                <select class="form-control select2 {{ $errors->has('vendor') ? 'is-invalid' : '' }}" name="vendor_id" id="vendor_id" required>
                    @foreach($vendors as $id => $entry)
                        <option value="{{ $id }}" {{ (old('vendor_id') ? old('vendor_id') : $goodReceipt->vendor->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('vendor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.vendor_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <label>{{ trans(tenant()->id.'/cruds.goodReceipt.fields.pay_type') }}</label>
                <select class="form-control {{ $errors->has('pay_type') ? 'is-invalid' : '' }}" name="pay_type" id="pay_type" >
                    <option value disabled {{ old('pay_type', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\GoodReceipt::PAY_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('pay_type', $goodReceipt->pay_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

            </div> --}}

            <div class="form-group">
                <label  for="gr_bill_no">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.gr_bill_no') }}</label>
                <input class="form-control {{ $errors->has('gr_bill_no') ? 'is-invalid' : '' }}" type="text" name="gr_bill_no" id="gr_bill_no" value="{{ old('gr_bill_no', $goodReceipt->gr_bill_no) }}" >
            </div>

            <div class="form-group">
                <label for="remarks">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks', $goodReceipt->remarks) }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.goodReceipt.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
