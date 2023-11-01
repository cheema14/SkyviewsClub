<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportItemClassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sport_item_class_create');
    }

    public function rules()
    {
        return [
            'item_class' => [
                'string',
                'required',
            ],
        ];
    }
}
