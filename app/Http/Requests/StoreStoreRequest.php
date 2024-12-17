<?php

namespace App\Http\Requests;

use App\Models\Store;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                new AlphaSpaces,
                'max:100',
            ],
        ];
    }
}
