@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sportItemName.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sport-item-names.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="item_name">{{ trans('cruds.sportItemName.fields.item_name') }}</label>
                <input class="form-control {{ $errors->has('item_name') ? 'is-invalid' : '' }}" type="text" name="item_name" id="item_name" value="{{ old('item_name', '') }}" required>
                @if($errors->has('item_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportItemName.fields.item_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="item_class_id">{{ trans('cruds.sportItemName.fields.item_class') }}</label>
                <select class="form-control select2 {{ $errors->has('item_class') ? 'is-invalid' : '' }}" name="item_class_id" id="item_class_id">
                    @foreach($item_classes as $id => $entry)
                        <option value="{{ $id }}" {{ old('item_class_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item_class'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_class') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportItemName.fields.item_class_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="item_rate">{{ trans('cruds.sportItemName.fields.item_rate') }}</label>
                <input class="form-control {{ $errors->has('item_rate') ? 'is-invalid' : '' }}" type="number" name="item_rate" id="item_rate" value="{{ old('item_rate', '') }}" step="1">
                @if($errors->has('item_rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportItemName.fields.item_rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit">{{ trans('cruds.sportItemName.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', 'Each') }}">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportItemName.fields.unit_helper') }}</span>
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