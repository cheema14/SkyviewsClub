@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card-body row">
            <div class="form-group col-md-4">
                <label class="required" for="name">{{ trans('cruds.employee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="father_name">{{ trans('cruds.employee.fields.father_name') }}</label>
                <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text" name="father_name" id="father_name" value="{{ old('father_name', $employee->father_name) }}" required>
                @if($errors->has('father_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('father_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.father_name_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="phone">{{ trans('cruds.employee.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.phone_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="designation">{{ trans('cruds.employee.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $employee->designation) }}">
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.designation_helper') }}</span>
            </div>
            
            <div class="form-group col-md-4">
                <label for="employee_type">{{ trans('cruds.employee.fields.employee_type') }}</label>
                <select class="form-control {{ $errors->has('employee_type') ? 'is-invalid' : '' }}" name="employee_type" id="employee_type">
                    <option value disabled {{ old('employee_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::EMPLOYEE_TYPE as $key => $label)
                        <option value="{{ $key }}" {{ (old('employee_type') ? old('employee_type') : $employee->employee_type ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.employee_type_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="job_type">{{ trans('cruds.employee.fields.job_type') }}</label>
                <select class="form-control {{ $errors->has('job_type') ? 'is-invalid' : '' }}" name="job_type" id="job_type">
                    <option value disabled {{ old('job_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="Permanent" {{ ($employee->job_type) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                    <option value="Temporary" {{ ($employee->job_type) == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                </select>
                @if($errors->has('job_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('job_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.job_type_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="service_no">{{ trans('cruds.employee.fields.service_no') }}</label>
                <input class="form-control {{ $errors->has('service_no') ? 'is-invalid' : '' }}" type="text" name="service_no" id="service_no" value="{{ old('service_no', $employee->service_no) }}">
                @if($errors->has('service_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.service_no_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="joining_date">{{ trans('cruds.employee.fields.joining_date') }}</label>
                <input  class="form-control birth_date {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" type="text" name="joining_date" id="joining_date" value="{{ old('joining_date',$employee->joining_date) }}">
                @if($errors->has('joining_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('joining_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.joining_date_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="date_of_birth">{{ trans('cruds.employee.fields.date_of_birth') }}</label>
                <input  class="form-control birth_date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth',$employee->date_of_birth) }}">
                @if($errors->has('date_of_birth'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_of_birth') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.date_of_birth_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="religion">{{ trans('cruds.employee.fields.religion') }}</label>
                <select class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" name="religion" id="religion">
                    <option value disabled {{ old('religion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::RELIGION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('religion') ? old('religion') : $employee->religion ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('religion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('religion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.religion_helper') }}</span>
            </div>

            <div x-data class="form-group col-md-4">
                <label class="required" for="cnic_no">{{ trans('cruds.employee.fields.cnic_no') }}</label>
                <input x-mask="99999-9999999-9" placeholder="XXXXX-XXXXXXX-X" class="form-control {{ $errors->has('cnic_no') ? 'is-invalid' : '' }}" type="text" name="cnic_no" id="cnic_no" value="{{ old('cnic_no',$employee->cnic_no) }}" required>
                @if($errors->has('cnic_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cnic_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.cnic_no_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="department">{{ trans('cruds.employee.fields.department') }}</label>
                <select class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department" id="department">
                    <option value disabled {{ old('department', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::DEPARTMENT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('department') ? old('department') : $employee->department ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.department_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="section">{{ trans('cruds.employee.fields.section') }}</label>
                <select class="form-control {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section" id="section">
                    <option value disabled {{ old('section', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::SECTION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('section') ? old('section') : $employee->section ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('section'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.section_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="gender">{{ trans('cruds.employee.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('gender') ? old('gender') : $employee->gender ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.gender_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="marital_status">{{ trans('cruds.employee.fields.marital_status') }}</label>
                <select class="form-control {{ $errors->has('marital_status') ? 'is-invalid' : '' }}" name="marital_status" id="marital_status">
                    <option value disabled {{ old('marital_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::MARITAL_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('marital_status') ? old('marital_status') : $employee->marital_status ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('marital_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marital_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.marital_status_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="blood_group">{{ trans('cruds.employee.fields.blood_group') }}</label>
                <select class="form-control {{ $errors->has('blood_group') ? 'is-invalid' : '' }}" name="blood_group" id="blood_group">
                    <option value disabled {{ old('blood_group', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::BLOOD_GROUP_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (old('blood_group') ? old('blood_group') : $employee->blood_group ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('blood_group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('blood_group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.blood_group_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="nationality">{{ trans('cruds.employee.fields.nationality') }}</label>
                <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', $employee->nationality) }}">
                @if($errors->has('nationality'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nationality') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.nationality_helper') }}</span>
            </div>


            <div class="form-group col-md-4">
                <label for="domicile">{{ trans('cruds.employee.fields.domicile') }}</label>
                <input class="form-control {{ $errors->has('domicile') ? 'is-invalid' : '' }}" type="text" name="domicile" id="domicile" value="{{ old('domicile', $employee->domicile) }}">
                @if($errors->has('domicile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('domicile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.domicile_helper') }}</span>
            </div>


            <div class="form-group col-md-4">
                <label for="qualification">{{ trans('cruds.employee.fields.qualification') }}</label>
                <input class="form-control {{ $errors->has('qualification') ? 'is-invalid' : '' }}" type="text" name="qualification" id="qualification" value="{{ old('qualification',$employee->domicile) }}">
                @if($errors->has('qualification'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qualification') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.qualification_helper') }}</span>
            </div>


            <div x-data class="form-group col-md-4">
                <label for="current_salary">{{ trans('cruds.employee.fields.current_salary') }}</label>
                <input x-mask="999999" class="form-control {{ $errors->has('current_salary') ? 'is-invalid' : '' }}" type="text" name="current_salary" id="current_salary" value="{{ old('current_salary',$employee->current_salary) }}">
                @if($errors->has('current_salary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_salary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.current_salary_helper') }}</span>
            </div><br />

            <div class="form-group col-md-4">
                <label for="address">{{ trans('cruds.employee.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $employee->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.address_helper') }}</span>
            </div>



            <div class="form-group">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </div>
    </form>
</div>



@endsection