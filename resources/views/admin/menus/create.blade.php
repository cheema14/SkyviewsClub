@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.create') }} {{ trans('cruds.menu.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.menus.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.menu.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="summary">{{ trans('cruds.menu.fields.summary') }}</label>
                <textarea class="form-control {{ $errors->has('summary') ? 'is-invalid' : '' }}" name="summary" id="summary">{{ old('summary') }}</textarea>
                @if($errors->has('summary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('summary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menu.fields.summary_helper') }}</span>
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