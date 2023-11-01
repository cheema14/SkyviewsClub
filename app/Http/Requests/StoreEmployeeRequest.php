<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_create');
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
                'unique:App\Models\Employee,cnic_no',
            ],
            'service_no' => [
                'unique:App\Models\Employee,service_no',
            ],
        ];
    }
}
