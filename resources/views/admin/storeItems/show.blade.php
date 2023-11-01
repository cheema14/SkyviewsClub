@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.store-items.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.storeItem.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.storeItem.fields.id') }}
                        </th>
                        <td>
                            {{ $storeItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.storeItem.fields.name') }}
                        </th>
                        <td>
                            {{ $storeItem->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.storeItem.fields.store') }}
                        </th>
                        <td>
                            {{ $storeItem->store->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.storeItem.fields.item') }}
                        </th>
                        <td>
                            {{ $storeItem->item->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.storeItem.fields.item_class') }}
                        </th>
                        <td>
                            {{ $storeItem->item_class->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.storeItem.fields.unit') }}
                        </th>
                        <td>
                            {{ $storeItem->unit->type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection