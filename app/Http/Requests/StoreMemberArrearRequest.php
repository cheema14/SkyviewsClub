<?php

namespace App\Http\Requests;

use \App\Models\PaymentReceipt;
use App\Rules\UniqueMonthlyMemberArrearRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberArrearRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create_advance_payment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            
            'receipt_no' => [
                'required',
            ],
            'receipt_date' => [
                'required',
                new UniqueMonthlyMemberArrearRequest(request()->input('receipt_date'), request()->input('member_id'), request()->input('pay_mode'))
            ],
            'received_amount' => [
                'required',
                'numeric',
            ],
        ];
    }
}
