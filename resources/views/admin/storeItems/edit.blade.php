@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.edit') }} {{ trans('cruds.storeItem.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.store-items.update", [$storeItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.storeItem.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $storeItem->name) }}" required>
                @if($errors->has('name'))
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.storeItem.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="store_id">{{ trans('cruds.storeItem.fields.store') }}</label>
                <select class="form-control select2 {{ $errors->has('store') ? 'is-invalid' : '' }}" name="store_id" id="store_id" required>
                    @foreach($stores as $id => $entry)
                    <option value="{{ $id }}" {{ (old('store_id') ? old('store_id') : $storeItem->store->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('store'))
                <div class="invalid-feedback">
                    {{ $errors->first('store') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.storeItem.fields.store_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="item_id">{{ trans('cruds.storeItem.fields.item') }}</label>
                <select id="item_type" class="form-control select2 {{ $errors->has('item') ? 'is-invalid' : '' }}" name="item_id" id="item_id" required>
                    @foreach($items as $id => $entry)
                    <option value="{{ $id }}" {{ (old('item_id') ? old('item_id') : $storeItem->item->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item'))
                <div class="invalid-feedback">
                    {{ $errors->first('item') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.storeItem.fields.item_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="item_class_id">{{ trans('cruds.storeItem.fields.item_class') }}</label>
                <select id="item_class" class="form-control select2 {{ $errors->has('item_class') ? 'is-invalid' : '' }}" name="item_class_id" id="item_class_id" required>
                    @foreach($item_classes as $id => $entry)
                    <option value="{{ $id }}" {{ (old('item_class_id') ? old('item_class_id') : $storeItem->item_class->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item_class'))
                <div class="invalid-feedback">
                    {{ $errors->first('item_class') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.storeItem.fields.item_class_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_id">{{ trans('cruds.storeItem.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                    @foreach($units as $id => $entry)
                    <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $storeItem->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                <div class="invalid-feedback">
                    {{ $errors->first('unit') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.storeItem.fields.unit_helper') }}</span>
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

@section('scripts')
<script type="text/javascript">
    function call_ajax(item_type_id)
    {
        $.ajax({
            url: "{{ route('admin.item-classes.get_by_item_type') }}?item_type_id=" + item_type_id
            , method: 'GET'
            , success: function(data) {
                $('#item_class').html(data.html);
            }
        });
    }

    $("#item_type").change(function() {
        $.ajax({
            url: "{{ route('admin.item-classes.get_by_item_type') }}?item_type_id=" + $(this).val()
            , method: 'GET'
            , success: function(data) {
                $('#item_class').html(data.html);
            }
        });
    });

    call_ajax("{{ $storeItem->item->id  }}");

</script>
@endsection
