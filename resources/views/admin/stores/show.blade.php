@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.stores.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.store.title') }}
    </div>

    <div class="card-body">
        <div class="responsive">
            
            <table class="table table-borderless table-hover table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.name') }}
                        </th>
                        <td>
                            {{ $store->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection