<?php

namespace App\Http\Requests;

use App\Models\MembershipType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMembershipTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('membership_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:membership_types,id',
        ];
    }
}
