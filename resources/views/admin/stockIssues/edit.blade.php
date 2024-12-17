@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.edit') }} {{ trans(tenant()->id.'/cruds.stockIssue.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stock-issues.update", [$stockIssue->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="issue_no">{{ trans(tenant()->id.'/cruds.stockIssue.fields.issue_no') }}</label>
                <input class="form-control {{ $errors->has('issue_no') ? 'is-invalid' : '' }}" type="text" name="issue_no" id="issue_no" value="{{ old('issue_no', $stockIssue->issue_no) }}" required>
                @if($errors->has('issue_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('issue_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.stockIssue.fields.issue_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="issue_date">{{ trans(tenant()->id.'/cruds.stockIssue.fields.issue_date') }}</label>
                <input class="form-control date {{ $errors->has('issue_date') ? 'is-invalid' : '' }}" type="text" name="issue_date" id="issue_date" value="{{ old('issue_date', $stockIssue->issue_date) }}" required>
                @if($errors->has('issue_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('issue_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.stockIssue.fields.issue_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="section_id">{{ trans(tenant()->id.'/cruds.stockIssue.fields.section') }}</label>
                <select class="form-control select2 {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section_id" id="section_id" required>
                    @foreach($sections as $id => $entry)
                        <option value="{{ $id }}" {{ (old('section_id') ? old('section_id') : $stockIssue->section->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('section'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.stockIssue.fields.section_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="store_id">{{ trans(tenant()->id.'/cruds.stockIssue.fields.store') }}</label>
                <select class="form-control select2 {{ $errors->has('store') ? 'is-invalid' : '' }}" name="store_id" id="store_id" required>
                    @foreach($stores as $id => $entry)
                        <option value="{{ $id }}" {{ (old('store_id') ? old('store_id') : $stockIssue->store->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('store'))
                    <div class="invalid-feedback">
                        {{ $errors->first('store') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.stockIssue.fields.store_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans(tenant()->id.'/cruds.stockIssue.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $stockIssue->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.stockIssue.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans(tenant()->id.'/cruds.stockIssue.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks', $stockIssue->remarks) }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.stockIssue.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection