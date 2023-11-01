<?php

namespace App\Http\Requests;

use App\Models\Member;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMemberRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('member_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'membership_no' => [
                'string',
                'required',
                'unique:members,membership_no',
            ],
            'mailing_address' => [
                'string',
                'nullable',
            ],
            'telephone_off' => [
                'string',
                'nullable',
            ],
            'cell_no' => [
                'string',
                'nullable',
            ],
            'cnic_no' => [
                'string',
                'required',
                'unique:App\Models\Member,cnic_no',
            ],
            'pak_svc_no' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'husband_father_name' => [
                'string',
                'required',
            ],
            'date_of_birth' => [
                'date',
                // 'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'qualification' => [
                'string',
                'nullable',
            ],
            'station_city' => [
                'string',
                'nullable',
            ],
            'tel_res' => [
                'string',
                'nullable',
            ],
            'date_of_membership' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'nationality' => [
                'string',
                'nullable',
            ],
            'permanent_address' => [
                'string',
                'nullable',
            ],
            'membership_fee' => [
                'string',
                'nullable',
            ],
            'membership_status' => [
                'required',
            ],
        ];
    }
}
