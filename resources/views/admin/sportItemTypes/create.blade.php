@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sportItemType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sport-item-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="item_type">{{ trans('cruds.sportItemType.fields.item_type') }}</label>
                <input class="form-control {{ $errors->has('item_type') ? 'is-invalid' : '' }}" type="text" name="item_type" id="item_type" value="{{ old('item_type', '') }}">
                @if($errors->has('item_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportItemType.fields.item_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="division_id">{{ trans('cruds.sportItemType.fields.division') }}</label>
                <select class="form-control select2 {{ $errors->has('division') ? 'is-invalid' : '' }}" name="division_id" id="division_id" required>
                    @foreach($divisions as $id => $entry)
                        <option value="{{ $id }}" {{ old('division_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('division'))
                    <div class="invalid-feedback">
                        {{ $errors->first('division') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportItemType.fields.division_helper') }}</span>
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