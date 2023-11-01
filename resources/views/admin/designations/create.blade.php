@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
            {{ trans('global.create') }} {{ trans('cruds.designation.title_singular') }}
        </h4>
    </div>
    
    

    <div class="card-body">
        <form method="POST" action="{{ route("admin.designations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('cruds.designation.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.title_helper') }}</span>
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