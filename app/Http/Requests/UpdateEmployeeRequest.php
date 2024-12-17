<?php

namespace App\Http\Requests;

use App\Models\Employee;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:70',
            ],
            'father_name' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:70',
            ],
            'phone' => [
                'string',
                'required',
                'min:12',
                'max:12'
            ],
            'designation' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:50',
            ],
            'cnic_no' => [
                'required',
                Rule::unique('employees')->ignore($this->employee->id),
                'min:15'
            ],
            'service_no' => [
                Rule::unique('employees')->ignore($this->employee->id),
                'max:100',
                new AlphaSpaces,
            ],
            'employment_type' => [
                'string',
                Rule::in(array_keys(Employee::EMPLOYEE_TYPE)),
            ],
            'cell_no' => [
                'string',
                'min:12',
            ],
            'joining_date' => [
                'date',
                'before_or_equal:today',
                'date_format:' . config('panel.date_format'),
            ],
            'date_of_birth' => [
                'date',
                'before_or_equal:today',
                'date_format:' . config('panel.date_format'),
            ],
            'job_type' => [
                'string',
                'in:Permanent,Temporary',
            ],
            'religion' => [
                'string',
                Rule::in(array_keys(Employee::RELIGION_SELECT)),
            ],
            'department' => [
                'string',
                'max:100',
                new AlphaSpaces,
            ],
            'section' => [
                'string',
                'max:100',
                new AlphaSpaces,
            ],
            'gender' => [
                'string',
                Rule::in(array_keys(Employee::GENDER_SELECT))
            ],
            'marital_status' => [
                'string',
                Rule::in(array_keys(EMPLOYEE::MARITAL_SELECT))
            ],
            'blood_group' => [
                'string',
                Rule::in(array_keys(EMPLOYEE::BLOOD_GROUP_SELECT))
            ],
            'nationality' => [
                'string',
                'max:100',
                new AlphaSpaces,
            ],
            'domicile' => [
                'string',
                'max:100',
                new AlphaSpaces,
            ],
            'qualification' => [
                'string',
                'max:50'
            ],
            'current_salary' => [
                'integer',
                'digits_between:1,6',
            ],
            'address' => [
                'string',
                'max:250'
            ],
            'temp_address' => [
                'string',
                'max:250'
            ],
            'salary_mode' => [
                'string',
                Rule::in(array_keys(EMPLOYEE::SALARY_MODE))
            ],
            'bank_name' => [
                'string',
                'max:60',
                new AlphaSpaces,
            ],
            'bank_account_no' => [
                'string',
                'max:50',
                new AlphaSpaces,
            ],
        ];
    }

    public function messages(){
        return [
            'cnic_no.min' => ':attribute should be 13 digits. the - hypens take 2 so it becomes 15.'
        ];
    }
}
