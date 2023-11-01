<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportItemNameRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sport_item_name_create');
    }

    public function rules()
    {
        return [
            'item_name' => [
                'string',
                'required',
            ],
            'item_class_id' => [
                'required',
                'string',
            ],
            'item_rate' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unit' => [
                'string',
                'required',
            ],
        ];
    }
}
