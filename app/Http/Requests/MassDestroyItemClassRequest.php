<?php

namespace App\Http\Requests;

use App\Models\ItemClass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyItemClassRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('item_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:item_classes,id',
        ];
    }
}
