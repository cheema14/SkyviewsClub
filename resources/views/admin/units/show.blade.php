@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-dark" href="{{ route('admin.units.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <h5>
            {{ trans('global.show') }} {{ trans('cruds.unit.title') }}
        </h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">            
            <table class="table table-bordered table-striped">
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection