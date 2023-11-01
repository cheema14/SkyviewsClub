@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.itemClass.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.item-classes.update", [$itemClass->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="item_type_id">{{ trans('cruds.itemClass.fields.item_type') }}</label>
                <select class="form-control select2 {{ $errors->has('item_type') ? 'is-invalid' : '' }}" name="item_type_id" id="item_type_id" required>
                    @foreach($item_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('item_type_id') ? old('item_type_id') : $itemClass->item_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itemClass.fields.item_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.itemClass.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $itemClass->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.itemClass.fields.name_helper') }}</span>
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