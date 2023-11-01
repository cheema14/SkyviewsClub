<?php

namespace App\Http\Requests;

use App\Models\SportBillingItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySportBillingItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sport_billing_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sport_billing_items,id',
        ];
    }
}
