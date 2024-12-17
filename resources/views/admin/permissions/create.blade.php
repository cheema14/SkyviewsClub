@extends('layouts.'.tenant()->id .'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
            {{ trans(tenant()->id .'/global.create') }} {{ trans(tenant()->id .'/cruds.permission.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans(tenant()->id .'/cruds.permission.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id .'/cruds.permission.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-success px-5" type="submit">
                    {{ trans(tenant()->id .'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection