@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.tableTop.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="form-group">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.table-tops.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.tableTop.fields.id') }}
                        </th>
                        <td>
                            {{ $tableTop->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.tableTop.fields.code') }}
                        </th>
                        <td>
                            {{ $tableTop->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.tableTop.fields.capacity') }}
                        </th>
                        <td>
                            {{ $tableTop->capacity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.tableTop.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\TableTop::STATUS_SELECT[$tableTop->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.table-tops.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>



@endsection