@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.sportItemName.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-item-names.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.id') }}
                        </th>
                        <td>
                            {{ $sportItemName->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.item_name') }}
                        </th>
                        <td>
                            {{ $sportItemName->item_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.item_class') }}
                        </th>
                        <td>
                            {{ $sportItemName->item_class->item_class ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.item_rate') }}
                        </th>
                        <td>
                            {{ $sportItemName->item_rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemName.fields.unit') }}
                        </th>
                        <td>
                            {{ $sportItemName->unit }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-item-names.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection