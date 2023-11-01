@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.edit') }} {{ trans('cruds.menuItemCategory.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.menu-item-categories.update", [$menuItemCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="menus">{{ trans('cruds.item.fields.menu') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('menus') ? 'is-invalid' : '' }}" name="menus[]" id="menus" multiple>
                    @foreach($menus as $id => $menu)
                        <option value="{{ $id }}" {{ (in_array($id, old('menus', [])) || $menuItemCategory->menus->contains($id)) ? 'selected' : '' }}>{{ $menu }}</option>
                    @endforeach
                </select>
                @if($errors->has('menus'))
                    <div class="invalid-feedback">
                        {{ $errors->first('menus') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.item.fields.menu_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.menuItemCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $menuItemCategory->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.menuItemCategory.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
