<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGrItemDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gr_item_detail_edit');
    }

    public function rules()
    {
        return [
            'item_id' => [
                'required',
                'integer',
            ],
            'unit_id' => [
                'required',
                'integer',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unit_rate' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_amount' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'expiry_date' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
                'required',
            ],
            // 'purchase_date' => [
            //     'date_format:' . config('panel.date_format'),
            //     'nullable',
            //     'required',
            // ],
            'gr_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
