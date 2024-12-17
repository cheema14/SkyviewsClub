@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.permissions.index') }}">
        {{ trans(tenant()->id .'/global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h4>
            {{ trans(tenant()->id .'/global.show') }} {{ trans(tenant()->id .'/cruds.permission.title') }}
        </h4>
    </div>

    <div class="card-body">            
        <table class="table table-borderless table-hover table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans(tenant()->id .'/cruds.permission.fields.id') }}
                    </th>
                    <td>
                        {{ $permission->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans(tenant()->id .'/cruds.permission.fields.title') }}
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