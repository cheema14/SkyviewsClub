<?php

namespace App\Http\Requests;

use App\Models\GrItemDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGrItemDetailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('gr_item_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:gr_item_details,id',
        ];
    }
}
