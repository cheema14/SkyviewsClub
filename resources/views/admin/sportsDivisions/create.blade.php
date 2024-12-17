@extends('layouts.'.tenant()->id.'/admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.sportsDivision.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sports-divisions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="division">{{ trans(tenant()->id.'/cruds.sportsDivision.fields.division') }}</label>
                <input class="form-control {{ $errors->has('division') ? 'is-invalid' : '' }}" type="text" name="division" id="division" value="{{ old('division', 'Sports') }}">
                @if($errors->has('division'))
                    <div class="invalid-feedback">
                        {{ $errors->first('division') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsDivision.fields.division_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection