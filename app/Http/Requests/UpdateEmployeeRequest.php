<?php

namespace App\Http\Requests;

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
            ],
            'father_name' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'nullable',
                'required',
            ],
            'designation' => [
                'string',
                'nullable',
                'required',
            ],
            'cnic_no' => [
                Rule::unique('employees')->ignore($this->employee->id),
            ],
            'service_no' => [
                Rule::unique('employees')->ignore($this->employee->id),
            ],
        ];
    }
}
