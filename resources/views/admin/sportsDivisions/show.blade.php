@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.sportsDivision.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sports-divisions.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsDivision.fields.id') }}
                        </th>
                        <td>
                            {{ $sportsDivision->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.sportsDivision.fields.division') }}
                        </th>
                        <td>
                            {{ $sportsDivision->division }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sports-divisions.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection