<?php

namespace App\Http\Requests;

use App\Models\StockIssue;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStockIssueRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stock_issue_create');
    }

    public function rules()
    {
        return [
            'issue_no' => [
                'string',
                'required',
            ],
            'issue_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'section_id' => [
                'required',
                'integer',
            ],
            'store_id' => [
                'required',
                'integer',
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
            'items.*.item_id' => ['required'],
            'items.*.unit_id' => ['required'],
            'items.*.lot_no' => ['required'],
            'items.*.stock_required' => ['required'],
            'items.*.issued_qty' => ['required']
        ];
    }

    public function messages(){

        return [
            'items.*.item_id' => 'Select any item.',
            'items.*.unit_id' => 'Select any unit.',
            'items.*.lot_no' => 'Add item`s Lot No.',
            'items.*.stock_required' => 'Add item`s required stock.',
            'items.*.issued_qty' => 'Add item`s issued Quantity.',
        ];
    }
}
