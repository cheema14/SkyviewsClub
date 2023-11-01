@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.membership-categories.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.membershipCategory.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $membershipCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $membershipCategory->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection