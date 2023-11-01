<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSportsDivisionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sports_division_create');
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
