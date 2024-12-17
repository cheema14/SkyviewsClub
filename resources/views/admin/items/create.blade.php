@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.item.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.items.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans(tenant()->id.'/cruds.item.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.item.fields.title_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="menus">{{ trans(tenant()->id.'/cruds.item.fields.menu') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans(tenant()->id.'/global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans(tenant()->id.'/global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('menus') ? 'is-invalid' : '' }}" name="menus[]" id="menus" multiple>
                    @foreach($menus as $id => $menu)
                        <option value="{{ $id }}" {{ in_array($id, old('menus', [])) ? 'selected' : '' }}>{{ $menu }}</option>
                    @endforeach
                </select>
                @if($errors->has('menus'))
                    <div class="invalid-feedback">
                        {{ $errors->first('menus') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.item.fields.menu_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label class="required" for="menu_item_category_id">{{ trans(tenant()->id.'/cruds.item.fields.menu_item_category') }}</label>
                <select class="form-control select2 {{ $errors->has('menu_item_category') ? 'is-invalid' : '' }}" name="menu_item_category_id" id="menu_item_category_id" required>
                    @foreach($menu_item_categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('menu_item_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('menu_item_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('menu_item_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.item.fields.menu_item_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="summary">{{ trans(tenant()->id.'/cruds.item.fields.summary') }}</label>
                <textarea class="form-control {{ $errors->has('summary') ? 'is-invalid' : '' }}" name="summary" id="summary">{{ old('summary') }}</textarea>
                @if($errors->has('summary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('summary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.item.fields.summary_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans(tenant()->id.'/cruds.item.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.item.fields.price_helper') }}</span>
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
