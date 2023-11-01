<?php

namespace App\Http\Requests;

use App\Models\StockIssue;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStockIssueRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('stock_issue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:stock_issues,id',
        ];
    }
}
