<?php

namespace App\Http\Requests;

use App\Models\GrItemDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGrItemDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gr_item_detail_create');
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
                'required',
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'purchase_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'gr_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
