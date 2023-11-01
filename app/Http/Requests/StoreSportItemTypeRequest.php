<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportItemTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sport_item_type_create');
    }

    public function rules()
    {
        return [
            'item_type' => [
                'required',
                'string',
            ],
            'division_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
