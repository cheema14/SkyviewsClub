<?php

namespace App\Http\Requests;

use App\Models\Designation;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDesignationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
                new AlphaSpaces
            ],
        ];
    }
}
