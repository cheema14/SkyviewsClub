<?php

namespace App\Http\Requests;

use App\Models\StockIssue;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStockIssueRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stock_issue_edit');
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
        ];
    }
}
