<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportsBillingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sports_billing_create');
    }

    public function rules()
    {
        return [
            'membership_no' => [
                'string',
                'nullable',
                'exists:members,membership_no',
                'required_if:non_member_name,==,null',
            ],
            'member_name' => [
                'string',
                'nullable',
                // 'required_with:membership_no',
            ],
            'non_member_name' => [
                'string',
                'nullable',
            ],
            'bill_date' => [
                'required',
                'date_format:'.config('panel.date_format'),
            ],
            'bill_number' => [
                'string',
                'nullable',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
            'ref_club' => [
                'string',
                'nullable',
            ],
            'club_id_ref' => [
                'string',
                'nullable',
            ],
            'tee_off' => [
                'string',
                'nullable',
            ],
            'holes' => [
                'string',
                'nullable',
            ],
            'caddy' => [
                'string',
                'nullable',
            ],
            'temp_mbr' => [
                'string',
                'nullable',
            ],
            'temp_caddy' => [
                'string',
                'nullable',
            ],
            'gross_total' => [
                'nullable',
                'numeric',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_payable' => [
                'nullable',
                'numeric',
                'min:-2147483648',
                'max:2147483647',
            ],
            'bank_charges' => [
                'numeric',
            ],
            'net_pay' => [
                'numeric',
            ],
        ];
    }
}
