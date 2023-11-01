<?php

namespace App\Http\Requests;

use App\Models\TableTop;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTableTopRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('table_top_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
            ],
            'capacity' => [
                'string',
                'nullable',
            ],
        ];
    }
}
