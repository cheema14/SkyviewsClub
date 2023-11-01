@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.item-types.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h5>
        {{ trans('global.show') }} {{ trans('cruds.itemType.title') }}
        </h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.itemType.fields.id') }}
                        </th>
                        <td>
                            {{ $itemType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.itemType.fields.type') }}
                        </th>
                        <td>
                            {{ $itemType->type }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection