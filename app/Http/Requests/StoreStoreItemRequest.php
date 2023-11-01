<?php

namespace App\Http\Requests;

use App\Models\StoreItem;
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
            ],
            'store_id' => [
                'required',
                'integer',
            ],
            'item_id' => [
                'required',
                'integer',
            ],
            'item_class_id' => [
                'required',
                'integer',
            ],
            'unit_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
