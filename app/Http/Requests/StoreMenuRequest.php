<?php

namespace App\Http\Requests;

use App\Models\Menu;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('menu_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:30'
            ],
            'summary' => [
                'string', 'max:300'
            ],
            'roles'=> [
                'required',
                'array',
            ],
            'roles.*' => [
                Rule::exists('roles', 'id')->whereNull('deleted_at'),
            ]
        ];
    }

    public function messages(){
        return ['roles.*.exists' => 'The selected :attribute is invalid.',];
    }
}
