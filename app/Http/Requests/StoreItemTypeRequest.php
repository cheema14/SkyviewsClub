<?php

namespace App\Http\Requests;

use App\Models\ItemType;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreItemTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('item_type_create');
    }

    public function rules()
    {
        return [
            'type' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:30'
            ],
        ];
    }
}
