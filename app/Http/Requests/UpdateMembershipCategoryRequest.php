<?php

namespace App\Http\Requests;

use App\Models\MembershipCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMembershipCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('membership_category_edit');
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
