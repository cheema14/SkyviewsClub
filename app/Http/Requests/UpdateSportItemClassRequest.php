<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSportItemClassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sport_item_class_edit');
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
