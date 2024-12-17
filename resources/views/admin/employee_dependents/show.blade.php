@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dependent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dependents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.id') }}
                        </th>
                        <td>
                            {{ $dependent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.name') }}
                        </th>
                        <td>
                            {{ $dependent->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.dob') }}
                        </th>
                        <td>
                            {{ $dependent->dob }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.relation') }}
                        </th>
                        <td>
                            {{ App\Models\Dependent::RELATION_SELECT[$dependent->relation] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.occupation') }}
                        </th>
                        <td>
                            {{ $dependent->occupation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.nationality') }}
                        </th>
                        <td>
                            {{ $dependent->nationality }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.golf_hcap') }}
                        </th>
                        <td>
                            {{ $dependent->golf_hcap }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.allow_credit') }}
                        </th>
                        <td>
                            {{ App\Models\Dependent::ALLOW_CREDIT_SELECT[$dependent->allow_credit] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dependent.fields.photo') }}
                        </th>
                        <td>
                            @if($dependent->photo)
                                <a href="{{ $dependent->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $dependent->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dependents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection