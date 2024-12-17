@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.edit') }} {{ trans(tenant()->id.'/cruds.sportItemClass.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sport-item-classes.update", [$sportItemClass->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="item_class">{{ trans(tenant()->id.'/cruds.sportItemClass.fields.item_class') }}</label>
                <input class="form-control {{ $errors->has('item_class') ? 'is-invalid' : '' }}" type="text" name="item_class" id="item_class" value="{{ old('item_class', $sportItemClass->item_class) }}">
                @if($errors->has('item_class'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_class') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportItemClass.fields.item_class_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="item_type_id">{{ trans(tenant()->id.'/cruds.sportItemClass.fields.item_type') }}</label>
                <select class="form-control select2 {{ $errors->has('item_type') ? 'is-invalid' : '' }}" name="item_type_id" id="item_type_id">
                    @foreach($item_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('item_type_id') ? old('item_type_id') : $sportItemClass->item_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportItemClass.fields.item_type_helper') }}</span>
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