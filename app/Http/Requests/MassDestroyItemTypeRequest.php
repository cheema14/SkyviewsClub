<?php

namespace App\Http\Requests;

use App\Models\ItemType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyItemTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('item_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:item_types,id',
        ];
    }
}
