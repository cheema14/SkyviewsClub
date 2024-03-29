<?php

namespace App\Http\Requests;

use App\Models\ItemType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateItemTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('item_type_edit');
    }

    public function rules()
    {
        return [
            'type' => [
                'string',
                'required',
            ],
        ];
    }
}
