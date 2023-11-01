<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSportItemTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sport_item_type_edit');
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
