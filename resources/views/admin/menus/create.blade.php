@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.menu.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.menus.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans(tenant()->id.'/cruds.menu.fields.title') }}</label>
                <input maxlength="30" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.menu.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="summary">{{ trans(tenant()->id.'/cruds.menu.fields.summary') }}</label>
                <textarea class="form-control {{ $errors->has('summary') ? 'is-invalid' : '' }}" name="summary" id="summary">{{ old('summary') }}</textarea>
                @if($errors->has('summary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('summary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.menu.fields.summary_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans(tenant()->id.'/cruds.user.fields.roles') }}</label>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" multiple="true" name="roles[]" id="roles" required>
                    @foreach($roles as $id => $role)
                        <option data-title="{{ $role }}" value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.user.fields.roles_helper') }}</span>
            </div>
            
            <div class="form-check mb-5">
                <input type="hidden" value="0"  name="has_discount">
                <input class="form-check-input" type="checkbox" value="1"  name="has_discount" id="has_discount">
                <label class="form-check-label" for="form_discount">
                    Please check this box if this menu offers discount
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn-success px-5" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection