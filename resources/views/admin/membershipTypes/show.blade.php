@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.membership-types.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.membershipType.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            
            <table class="table table-borderless table-hover table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipType.fields.id') }}
                        </th>
                        <td>
                            {{ $membershipType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipType.fields.name') }}
                        </th>
                        <td>
                            {{ $membershipType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipType.fields.effective_from') }}
                        </th>
                        <td>
                            {{ $membershipType->effective_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipType.fields.subscription_fee') }}
                        </th>
                        <td>
                            {{ $membershipType->subscription_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipType.fields.security_fee') }}
                        </th>
                        <td>
                            {{ $membershipType->security_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.membershipType.fields.monthly_fee') }}
                        </th>
                        <td>
                            {{ $membershipType->monthly_fee }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection