@extends('layouts.'.tenant()->id.'.admin')
@section('content')
<div class="form-group">
    {{-- <a class="btn btn-dark" href="{{ route('admin.employees.index') }}">
        {{ trans(tenant()->id.'/global.back_to_list') }}
    </a> --}}
    {{-- <img src="{{ asset('storage/employees/1/6731a8aba906b_pcom-dashboard.png') }}" > --}}
    
</div>
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.employee.title') }}
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.employee_photo') }}
                        </th>
                        <td>
                            <a target="_blank" href="{{ $employee->employee_photo?->getUrl() }}">
                                <img src="{{ $employee->employee_photo?->getUrl('thumb') }}" class="img-fluid" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.id') }}
                        </th>
                        <td>
                            {{ $employee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.name') }}
                        </th>
                        <td>
                            {{ $employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.father_name') }}
                        </th>
                        <td>
                            {{ $employee->father_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.phone') }}
                        </th>
                        <td>
                            {{ $employee->phone ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.designation') }}
                        </th>
                        <td>
                            {{ $employee->designation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.employee_type') }}
                        </th>
                        <td>
                            {{ $employee->employee_type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.service_no') }}
                        </th>
                        <td>
                            {{ $employee->service_no ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.joining_date') }}
                        </th>
                        <td>
                            {{ $employee->joining_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.date_of_birth') }}
                        </th>
                        <td>
                            {{ $employee->date_of_birth ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.religion') }}
                        </th>
                        <td>
                            {{ $employee->religion ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.cnic_no') }}
                        </th>
                        <td>
                            {{ $employee->cnic_no ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.address') }}
                        </th>
                        <td>
                            {{ $employee->address ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.department') }}
                        </th>
                        <td>
                            {{ $employee->department ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.section') }}
                        </th>
                        <td>
                            {{ $employee->section ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Employee::GENDER_SELECT[$employee->gender] ?? '' }} 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.marital_status') }}
                        </th>
                        <td>
                            {{ $employee->marital_status ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.blood_group') }}
                        </th>
                        <td>
                            {{ $employee->blood_group ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.nationality') }}
                        </th>
                        <td>
                            {{ $employee->nationality ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.domicile') }}
                        </th>
                        <td>
                            {{ $employee->domicile ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.qualification') }}
                        </th>
                        <td>
                            {{ $employee->qualification ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.current_salary') }}
                        </th>
                        <td>
                            {{ $employee->current_salary ?? '0' }} PKR
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $employee->bank_name ?? 'N/A' }} 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.bank_account_no') }}
                        </th>
                        <td>
                            {{ $employee->bank_account_no ?? 'N/A' }} 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.salary_mode') }}
                        </th>
                        <td>
                            {{ $employee->salary_mode ?? 'N/A' }} 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.job_type') }}
                        </th>
                        <td>
                            {{ $employee->job_type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
