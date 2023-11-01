@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.permissions.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h4>
            {{ trans('global.show') }} {{ trans('cruds.permission.title') }}
        </h4>
    </div>

    <div class="card-body">            
        <table class="table table-borderless table-hover table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.permission.fields.id') }}
                    </th>
                    <td>
                        {{ $permission->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.permission.fields.title') }}
                    </th>
                    <td>
                        {{ $permission->title }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



@endsection