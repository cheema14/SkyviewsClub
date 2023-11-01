<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSportsDivisionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sports_division_edit');
    }

    public function rules()
    {
        return [
            'division' => [
                'required',
                'string',
            ],
        ];
    }
}
