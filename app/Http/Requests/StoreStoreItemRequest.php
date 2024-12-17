<?php

namespace App\Http\Requests;

use App\Models\StoreItem;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStoreItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store_item_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:30',
            ],
            'store_id' => [
                'required',
                'integer',
                'exists:stores,id',
            ],
            'item_id' => [
                'required',
                'integer',
                'exists:item_types,id',
            ],
            'item_class_id' => [
                'required',
                'integer',
                'exists:item_classes,id',
            ],
            'unit_id' => [
                'required',
                'integer',
                'exists:units,id',
            ],
        ];
    }
}
