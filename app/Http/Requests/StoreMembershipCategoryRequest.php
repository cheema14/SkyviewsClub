<?php

namespace App\Http\Requests;

use App\Models\MembershipCategory;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMembershipCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('membership_category_create');
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
        ];
    }
}
