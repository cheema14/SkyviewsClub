<?php

namespace App\Http\Requests;

use App\Models\Section;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('section_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                new AlphaSpaces,
                'size:100',
            ],
        ];
    }
}
