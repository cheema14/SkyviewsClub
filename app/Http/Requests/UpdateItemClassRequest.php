<?php

namespace App\Http\Requests;

use App\Models\ItemClass;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateItemClassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('item_class_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:30'
            ],
            'item_type_id' => [
                'required',
                'integer',
                'exists:item_types,id',
            ],
        ];
    }
}
