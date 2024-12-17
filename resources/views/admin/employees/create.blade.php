@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.employee.title_singular') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.employees.store") }}" enctype="multipart/form-data">
    @csrf
        <div class="card-body row">

            <div class="form-group col-md-4">
                <label class="required" for="name">{{ trans(tenant()->id.'/cruds.employee.fields.name') }}</label>
                <input maxlength="30" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.name_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="father_name">{{ trans(tenant()->id.'/cruds.employee.fields.father_name') }}</label>
                <input maxlength="30" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text" name="father_name" id="father_name" value="{{ old('father_name', '') }}" required>
                @if($errors->has('father_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('father_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.father_name_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="phone">{{ trans(tenant()->id.'/cruds.employee.fields.phone') }}</label>
                <input x-mask="9999-9999999" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.phone_helper') }}</span>
            </div>
            
            <div class="form-group col-md-4">
                <label for="cell_number">{{ trans(tenant()->id.'/cruds.employee.fields.cell_number') }}</label>
                <input x-mask="9999-9999999" class="form-control {{ $errors->has('cell_number') ? 'is-invalid' : '' }}" type="text" name="cell_number" id="cell_number" value="{{ old('cell_number', '') }}">
                @if($errors->has('cell_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cell_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.cell_number_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="designation">{{ trans(tenant()->id.'/cruds.employee.fields.designation') }}</label>
                <input maxlength="50" class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', '') }}">
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.designation_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="employee_type">{{ trans(tenant()->id.'/cruds.employee.fields.employee_type') }}</label>
                <select class="form-control {{ $errors->has('employee_type') ? 'is-invalid' : '' }}" name="employee_type" id="employee_type">
                    <option value disabled {{ old('employee_type', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::EMPLOYEE_TYPE as $key => $label)
                        <option value="{{ $key }}" {{ old('employee_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.employee_type_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="job_type">{{ trans(tenant()->id.'/cruds.employee.fields.job_type') }}</label>
                <select class="form-control {{ $errors->has('job_type') ? 'is-invalid' : '' }}" name="job_type" id="job_type">
                    <option value disabled {{ old('job_type', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Temporary">Temporary</option>
                </select>
                @if($errors->has('job_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('job_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.job_type_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="service_no">{{ trans(tenant()->id.'/cruds.employee.fields.service_no') }}</label>
                <input class="form-control {{ $errors->has('service_no') ? 'is-invalid' : '' }}" type="text" name="service_no" id="service_no" value="{{ old('service_no', '') }}">
                @if($errors->has('service_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.service_no_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="joining_date">{{ trans(tenant()->id.'/cruds.employee.fields.joining_date') }}</label>
                <input  class="form-control birth_date {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" type="text" name="joining_date" id="joining_date" value="{{ old('joining_date') }}">
                @if($errors->has('joining_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('joining_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.joining_date_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="date_of_birth">{{ trans(tenant()->id.'/cruds.employee.fields.date_of_birth') }}</label>
                <input  class="form-control birth_date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                @if($errors->has('date_of_birth'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_of_birth') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.date_of_birth_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="religion">{{ trans(tenant()->id.'/cruds.employee.fields.religion') }}</label>
                <select class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" name="religion" id="religion">
                    <option value disabled {{ old('religion', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::RELIGION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('religion', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('religion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('religion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.religion_helper') }}</span>
            </div>

            <div x-data class="form-group col-md-4">
                <label class="required" for="cnic_no">{{ trans(tenant()->id.'/cruds.employee.fields.cnic_no') }}</label>
                <input x-mask="99999-9999999-9" placeholder="XXXXX-XXXXXXX-X" class="form-control {{ $errors->has('cnic_no') ? 'is-invalid' : '' }}" type="text" name="cnic_no" id="cnic_no" value="{{ old('cnic_no', '') }}" required>
                @if($errors->has('cnic_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cnic_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.cnic_no_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="department">{{ trans(tenant()->id.'/cruds.employee.fields.department') }}</label>
                <input maxlength="100" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" type="text" name="department" id="department" value="{{ old('department', '') }}">
                {{-- <select class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department" id="department">
                    <option value disabled {{ old('department', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::DEPARTMENT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('department', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select> --}}
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.department_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="section">{{ trans(tenant()->id.'/cruds.employee.fields.section') }}</label>
                <input maxlength="100" class="form-control {{ $errors->has('section') ? 'is-invalid' : '' }}" type="text" name="section" id="section" value="{{ old('section', '') }}">
                {{-- <select class="form-control {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section" id="section">
                    <option value disabled {{ old('section', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::SECTION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('section', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select> --}}
                @if($errors->has('section'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.section_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="gender">{{ trans(tenant()->id.'/cruds.employee.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.gender_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="marital_status">{{ trans(tenant()->id.'/cruds.employee.fields.marital_status') }}</label>
                <select class="form-control {{ $errors->has('marital_status') ? 'is-invalid' : '' }}" name="marital_status" id="marital_status">
                    <option value disabled {{ old('marital_status', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::MARITAL_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('marital_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('marital_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marital_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.marital_status_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="blood_group">{{ trans(tenant()->id.'/cruds.employee.fields.blood_group') }}</label>
                <select class="form-control {{ $errors->has('blood_group') ? 'is-invalid' : '' }}" name="blood_group" id="blood_group">
                    <option value disabled {{ old('blood_group', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::BLOOD_GROUP_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('blood_group', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('blood_group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('blood_group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.blood_group_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="nationality">{{ trans(tenant()->id.'/cruds.employee.fields.nationality') }}</label>
                <input maxlength="100" class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', '') }}">
                @if($errors->has('nationality'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nationality') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.nationality_helper') }}</span>
            </div>


            <div class="form-group col-md-4">
                <label for="domicile">{{ trans(tenant()->id.'/cruds.employee.fields.domicile') }}</label>
                <input maxlength="100"  class="form-control {{ $errors->has('domicile') ? 'is-invalid' : '' }}" type="text" name="domicile" id="domicile" value="{{ old('domicile', '') }}">
                @if($errors->has('domicile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('domicile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.domicile_helper') }}</span>
            </div>


            <div class="form-group col-md-4">
                <label for="qualification">{{ trans(tenant()->id.'/cruds.employee.fields.qualification') }}</label>
                <input maxlength="50"  class="form-control {{ $errors->has('qualification') ? 'is-invalid' : '' }}" type="text" name="qualification" id="qualification" value="{{ old('qualification', '') }}">
                @if($errors->has('qualification'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qualification') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.qualification_helper') }}</span>
            </div>


            <div x-data class="form-group col-md-4">
                <label for="current_salary">{{ trans(tenant()->id.'/cruds.employee.fields.current_salary') }}</label>
                <input x-mask="999999" class="form-control {{ $errors->has('current_salary') ? 'is-invalid' : '' }}" type="text" name="current_salary" id="current_salary" value="{{ old('current_salary', '') }}">
                @if($errors->has('current_salary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_salary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.current_salary_helper') }}</span>
            </div><br />

            <div class="form-group col-md-4">
                <label for="address">{{ trans(tenant()->id.'/cruds.employee.fields.address') }}</label>
                <input maxlength="250"  class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.address_helper') }}</span>
            </div>
            
            <div class="form-group col-md-4">
                <label for="temp_address">{{ trans(tenant()->id.'/cruds.employee.fields.temp_address') }}</label>
                <input maxlength="250"  class="form-control {{ $errors->has('temp_address') ? 'is-invalid' : '' }}" type="text" name="temp_address" id="temp_address" value="{{ old('temp_address', '') }}">
                @if($errors->has('temp_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.temp_address_helper') }}</span>
            </div>
            
            <div class="form-group col-md-4">
                <label for="salary_mode">{{ trans(tenant()->id.'/cruds.employee.fields.salary_mode') }}</label>
                <select class="form-control {{ $errors->has('salary_mode') ? 'is-invalid' : '' }}" name="salary_mode" id="salary_mode">
                    <option value disabled {{ old('salary_mode', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::SALARY_MODE as $key => $label)
                        <option value="{{ $key }}" {{ old('salary_mode', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('salary_mode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('salary_mode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.salary_mode_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="bank_name">{{ trans(tenant()->id.'/cruds.employee.fields.bank_name') }}</label>
                <input maxlength="60" class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', '') }}">
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.bank_name_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="bank_account_no">{{ trans(tenant()->id.'/cruds.employee.fields.bank_account_no') }}</label>
                <input maxlength="50" class="form-control {{ $errors->has('bank_account_no') ? 'is-invalid' : '' }}" type="text" name="bank_account_no" id="bank_account_no" value="{{ old('bank_account_no', '') }}">
                @if($errors->has('bank_account_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.bank_account_no_helper') }}</span>
            </div>
            

            <div class="form-group col-md-12">
                <label for="employee_photo">{{ trans(tenant()->id.'/cruds.employee.fields.employee_photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('employee_photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('employee_photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.fields.employee_photo_helper') }}</span>
            </div>

            
            <div class="form-group col-md-12">
                <button class="btn btn-success px-5" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </div>
    </form>
</div>



@endsection

@section('scripts')

<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.employees.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    dictDefaultMessage: "Attach Employee`s picture",
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096,
      tenant_id: "{{ tenant()->id }}"
    },
    success: function (file, response) {
      $('form').find('input[name="employee_photo"]').remove()
      $('form').append('<input type="hidden" name="employee_photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="employee_photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
    @if(isset($employee) && $employee->employee_photo)
        var file = {!! json_encode($employee->employee_photo) !!}
            this.options.addedfile.call(this, file)
        this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="employee_photo" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
    @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }

</script>

@endsection