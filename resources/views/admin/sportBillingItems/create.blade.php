@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sportBillingItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sport-billing-items.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="billing_division_id">{{ trans('cruds.sportBillingItem.fields.billing_division') }}</label>
                <select class="form-control select2 {{ $errors->has('billing_division') ? 'is-invalid' : '' }}" name="billing_division_id" id="billing_division_id">
                    @foreach($billing_divisions as $id => $entry)
                        <option value="{{ $id }}" {{ old('billing_division_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('billing_division'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_division') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.billing_division_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_item_type_id">{{ trans('cruds.sportBillingItem.fields.billing_item_type') }}</label>
                <select class="form-control select2 {{ $errors->has('billing_item_type') ? 'is-invalid' : '' }}" name="billing_item_type_id" id="billing_item_type_id">
                    @foreach($billing_item_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('billing_item_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('billing_item_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_item_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.billing_item_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_item_class_id">{{ trans('cruds.sportBillingItem.fields.billing_item_class') }}</label>
                <select class="form-control select2 {{ $errors->has('billing_item_class') ? 'is-invalid' : '' }}" name="billing_item_class_id" id="billing_item_class_id">
                    @foreach($billing_item_classes as $id => $entry)
                        <option value="{{ $id }}" {{ old('billing_item_class_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('billing_item_class'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_item_class') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.billing_item_class_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_item_name_id">{{ trans('cruds.sportBillingItem.fields.billing_item_name') }}</label>
                <select class="form-control select2 {{ $errors->has('billing_item_name') ? 'is-invalid' : '' }}" name="billing_item_name_id" id="billing_item_name_id">
                    @foreach($billing_item_names as $id => $entry)
                        <option value="{{ $id }}" {{ old('billing_item_name_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('billing_item_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_item_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.billing_item_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.sportBillingItem.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="rate">{{ trans('cruds.sportBillingItem.fields.rate') }}</label>
                <input class="form-control {{ $errors->has('rate') ? 'is-invalid' : '' }}" type="number" name="rate" id="rate" value="{{ old('rate', '') }}" step="1" required>
                @if($errors->has('rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.sportBillingItem.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="1" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="billing_issue_item_id">{{ trans('cruds.sportBillingItem.fields.billing_issue_item') }}</label>
                <select class="form-control select2 {{ $errors->has('billing_issue_item') ? 'is-invalid' : '' }}" name="billing_issue_item_id" id="billing_issue_item_id">
                    @foreach($billing_issue_items as $id => $entry)
                        <option value="{{ $id }}" {{ old('billing_issue_item_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('billing_issue_item'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_issue_item') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportBillingItem.fields.billing_issue_item_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection