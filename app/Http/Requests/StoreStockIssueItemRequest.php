<?php

namespace App\Http\Requests;

use App\Models\StockIssueItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStockIssueItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stock_issue_item_create');
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
            'lot_no' => [
                'string',
            ],
            'stock_required' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'issued_qty' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
