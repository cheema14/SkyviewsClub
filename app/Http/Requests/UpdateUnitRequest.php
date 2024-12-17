<?php

namespace App\Http\Requests;

use App\Models\Unit;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_edit');
    }

    public function rules()
    {
        return [
            'type' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:30'
            ],
        ];
    }
}
