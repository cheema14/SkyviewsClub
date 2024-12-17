@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.membershipType.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.membership-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans(tenant()->id.'/cruds.membershipType.fields.name') }}</label>
                <input maxlength="100" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.membershipType.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="effective_from">{{ trans(tenant()->id.'/cruds.membershipType.fields.effective_from') }}</label>
                <input class="form-control membership_effective_from {{ $errors->has('effective_from') ? 'is-invalid' : '' }}" type="text" name="effective_from" id="effective_from" value="{{ old('effective_from') }}" required>
                @if($errors->has('effective_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('effective_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.membershipType.fields.effective_from_helper') }}</span>
            </div>
            <div x-data="{ mask: null }" class="form-group">
                <label class="required" for="subscription_fee">{{ trans(tenant()->id.'/cruds.membershipType.fields.subscription_fee') }}</label>
                <input maxlength="10" x-bind:x-mask="mask || '999999[.99]'"
                x-on:input="mask = $event.target.value.includes('.') ? '999999.99' : '999999'" class="form-control {{ $errors->has('subscription_fee') ? 'is-invalid' : '' }}" type="number" name="subscription_fee" id="subscription_fee" value="{{ old('subscription_fee', '') }}" step="0.01" required>
                @if($errors->has('subscription_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subscription_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.membershipType.fields.subscription_fee_helper') }}</span>
            </div>
            <div x-data="{ mask: null }" class="form-group">
                <label class="required" for="security_fee">{{ trans(tenant()->id.'/cruds.membershipType.fields.security_fee') }}</label>
                <input maxlength="10" x-bind:x-mask="mask || '999999[.99]'"
                x-on:input="mask = $event.target.value.includes('.') ? '999999.99' : '999999'" class="form-control {{ $errors->has('security_fee') ? 'is-invalid' : '' }}" type="number" name="security_fee" id="security_fee" value="{{ old('security_fee', '') }}" step="0.01" required>
                @if($errors->has('security_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('security_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.membershipType.fields.security_fee_helper') }}</span>
            </div>
            <div x-data="{ mask: null }" class="form-group">
                <label class="required" for="monthly_fee">{{ trans(tenant()->id.'/cruds.membershipType.fields.monthly_fee') }}</label>
                <input maxlength="10" x-on:input="mask = $event.target.value.includes('.') ? '999999.99' : '999999'" class="form-control {{ $errors->has('monthly_fee') ? 'is-invalid' : '' }}" type="number" name="monthly_fee" id="monthly_fee" value="{{ old('monthly_fee', '') }}" step="0.01" required>
                @if($errors->has('monthly_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('monthly_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.membershipType.fields.monthly_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-success px-5" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection