<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreGoodReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('good_receipt_create');
    }

    public function rules()
    {
        return [
            'gr_number' => [
                'string',
                'required',
                'unique:good_receipts',
            ],
            'store_id' => [
                'required',
                'integer',
            ],
            'gr_date' => [
                'required',
                'date_format:'.config('panel.date_format'),
            ],
            'vendor_id' => [
                'required',
                'integer',
            ],

            'items.*.quantity' => ['required'],
            'items.*.total_amount' => ['required'],
            'items.*.unit_id' => ['required'],
            'items.*.unit_rate' => ['required'],
            // 'items.*.expiry_date' => ['required'],
            // 'items.*.purchase_date' => ['required'],

        ];

    }

    public function messages()
    {

        return [
            'items.*.quantity' => 'Add item`s quantity.',
            'items.*.total_amount' => 'Add item`s total amount.',
            'items.*.unit_rate' => 'Add item`s unit rate.',
            'items.*.expiry_date' => 'Add item`s expiry date.',
            'items.*.purchase_date' => 'Add item`s purchase date.',
        ];
    }
}
