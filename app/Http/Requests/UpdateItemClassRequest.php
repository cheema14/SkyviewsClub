<?php

namespace App\Http\Requests;

use App\Models\ItemClass;
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
            ],
            'item_type_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
