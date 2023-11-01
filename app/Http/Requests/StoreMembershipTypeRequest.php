<?php

namespace App\Http\Requests;

use App\Models\MembershipType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMembershipTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('membership_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
