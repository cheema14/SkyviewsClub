<?php

namespace App\Http\Requests;

use App\Models\TableTop;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTableTopRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('table_top_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
                'string',
            ],
            'capacity' => [
                'string',
                'nullable',
            ],
            'status' => [
                'required',
                'string'
            ],
        ];
    }
}
