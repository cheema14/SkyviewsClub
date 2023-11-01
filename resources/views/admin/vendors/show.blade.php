@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.vendors.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vendor.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.name') }}
                        </th>
                        <td>
                            {{ $vendor->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $vendor->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.location') }}
                        </th>
                        <td>
                            {{ $vendor->location }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection