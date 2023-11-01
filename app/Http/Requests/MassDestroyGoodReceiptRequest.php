<?php

namespace App\Http\Requests;

use App\Models\GoodReceipt;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGoodReceiptRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('good_receipt_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:good_receipts,id',
        ];
    }
}
