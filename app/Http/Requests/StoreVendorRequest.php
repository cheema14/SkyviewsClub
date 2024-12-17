<?php

namespace App\Http\Requests;

use App\Models\Vendor;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVendorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vendor_create');
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
            'phone_number' => [
                'string',
                'nullable',
                'min:12',
            ],
            'location' => [
                'string',
                'nullable',
                'max:200',
            ],
        ];
    }
}
