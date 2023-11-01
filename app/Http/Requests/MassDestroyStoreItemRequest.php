<?php

namespace App\Http\Requests;

use App\Models\StoreItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStoreItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('store_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:store_items,id',
        ];
    }
}
