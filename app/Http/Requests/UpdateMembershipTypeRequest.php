<?php

namespace App\Http\Requests;

use App\Models\MembershipType;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMembershipTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('membership_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'max:100',
                new AlphaSpaces,
            ],
            'subscription_fee' => [
                'required',
                'numeric',
                'min:1',
                'max:9999999'
            ],
            'security_fee' => [
                'required',
                'numeric',
                'min:1',
                'max:9999999'
            ],
            'monthly_fee' => [
                'required',
                'numeric',
                'min:1',
                'max:9999999'
            ],
        ];
    }

    public function messages():array{

        return [
            'monthly_fee.min' => ':attribute can have minimum value 1',
            'monthly_fee.max' => ':attribute should be less than 10 Lac',
            'security_fee.min' => ':attribute can have minimum value 1',
            'security_fee.max' => ':attribute should be less than 10 Lac',
            'subscription_fee.min' => ':attribute can have minimum value 1',
            'subscription_fee.max' => ':attribute should be less than 10 Lac',
            
        ];
    }
}
