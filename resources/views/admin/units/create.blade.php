@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.create') }} {{ trans('cruds.unit.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.units.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.unit.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unit.fields.type_helper') }}</span>
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