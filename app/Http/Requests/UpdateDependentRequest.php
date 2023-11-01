<?php

namespace App\Http\Requests;

use App\Models\Dependent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDependentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dependent_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'dob' => [
                // 'required',
                // 'date_format:' . config('panel.date_format'),
            ],
            'relation' => [
                'required',
            ],
            'occupation' => [
                'string',
                'nullable',
            ],
            'nationality' => [
                'string',
                'nullable',
            ],
            'golf_hcap' => [
                'string',
                'nullable',
            ],
            'allow_credit' => [
                'required',
            ],
        ];
    }
}
