@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.sportItemType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-item-types.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>

            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemType.fields.id') }}
                        </th>
                        <td>
                            {{ $sportItemType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemType.fields.item_type') }}
                        </th>
                        <td>
                            {{ $sportItemType->item_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportItemType.fields.division') }}
                        </th>
                        <td>
                            {{ $sportItemType->sportsDivision->division ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sport-item-types.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection