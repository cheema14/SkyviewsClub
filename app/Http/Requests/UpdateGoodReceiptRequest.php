<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoodReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('good_receipt_edit');
    }

    public function rules()
    {
        return [
            'gr_number' => [
                'string',
                'required',
                'unique:good_receipts,gr_number,'.request()->route('good_receipt')->id,
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
        ];
    }
}
