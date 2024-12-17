@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.roles.index') }}">
        {{ trans(tenant()->id.'/global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h4>
            {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.role.title') }}
        </h4>
    </div>

    <div class="card-body">            
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans(tenant()->id.'/cruds.role.fields.id') }}
                    </th>
                    <td>
                        {{ $role->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans(tenant()->id.'/cruds.role.fields.title') }}
                    </th>
                    <td>
                        {{ $role->title }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans(tenant()->id.'/cruds.role.fields.permissions') }}
                    </th>
                    <td>
                        @foreach($role->permissions as $key => $permissions)
                            <span class="label label-info">{{ $permissions->title }}</span>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



@endsection