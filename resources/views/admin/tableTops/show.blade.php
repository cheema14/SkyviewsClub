@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.tableTop.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="form-group">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.table-tops.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tableTop.fields.id') }}
                        </th>
                        <td>
                            {{ $tableTop->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tableTop.fields.code') }}
                        </th>
                        <td>
                            {{ $tableTop->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tableTop.fields.capacity') }}
                        </th>
                        <td>
                            {{ $tableTop->capacity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tableTop.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\TableTop::STATUS_SELECT[$tableTop->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.table-tops.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>



@endsection