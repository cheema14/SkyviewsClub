@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.create') }} {{ trans('cruds.grItemDetail.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.gr-item-details.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="gr_id">{{ trans('cruds.grItemDetail.fields.gr') }}</label>
                <select class="form-control select2 {{ $errors->has('gr') ? 'is-invalid' : '' }}" name="gr_id" id="gr_id" required>
                    @foreach($grs as $id => $entry)
                        <option value="{{ $id }}" {{ old('gr_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('gr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gr') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.gr_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="item_id">{{ trans('cruds.grItemDetail.fields.item') }}</label>
                <select class="form-control select2 {{ $errors->has('item') ? 'is-invalid' : '' }}" name="item_id" id="item_id" required>
                    @foreach($items as $id => $entry)
                        <option value="{{ $id }}" {{ old('item_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.item_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_id">{{ trans('cruds.grItemDetail.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.grItemDetail.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" onchange="calculateAmount(this)" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_rate">{{ trans('cruds.grItemDetail.fields.unit_rate') }}</label>
                <input class="form-control {{ $errors->has('unit_rate') ? 'is-invalid' : '' }}" type="number" onchange="calculateAmount(this)" name="unit_rate" id="unit_rate" value="{{ old('unit_rate', '') }}" step="1" required>
                @if($errors->has('unit_rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.unit_rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total_amount">{{ trans('cruds.grItemDetail.fields.total_amount') }}</label>
                <input class="form-control {{ $errors->has('total_amount') ? 'is-invalid' : '' }}" type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', '') }}" step="1" required>
                @if($errors->has('total_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.total_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expiry_date">{{ trans('cruds.grItemDetail.fields.expiry_date') }}</label>
                <input class="form-control date {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" type="text" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" required>
                @if($errors->has('expiry_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('expiry_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.expiry_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="purchase_date">{{ trans('cruds.grItemDetail.fields.purchase_date') }}</label>
                <input class="form-control date {{ $errors->has('purchase_date') ? 'is-invalid' : '' }}" type="text" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}" required>
                @if($errors->has('purchase_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('purchase_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.grItemDetail.fields.purchase_date_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-success px-5" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

<script>

    function calculateAmount(index) {

        if ($("#quantity").val()) {
            $("#total_amount").val($("#quantity").val() * $("#unit_rate").val());
        }

        if($("#unit_rate").val()){
            $("#total_amount").val($("#quantity").val() * $("#unit_rate").val());

        }

    }

</script>
