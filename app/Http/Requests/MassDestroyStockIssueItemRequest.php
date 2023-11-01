<?php

namespace App\Http\Requests;

use App\Models\StockIssueItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStockIssueItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('stock_issue_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:stock_issue_items,id',
        ];
    }
}
