@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sportItemClass.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-item-classes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sportItemClass.fields.id') }}
                        </th>
                        <td>
                            {{ $sportItemClass->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportItemClass.fields.item_class') }}
                        </th>
                        <td>
                            {{ $sportItemClass->item_class }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sportItemClass.fields.item_type') }}
                        </th>
                        <td>
                            {{ $sportItemClass->item_type->item_type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-item-classes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection