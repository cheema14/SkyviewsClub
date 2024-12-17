<?php

namespace App\Http\Requests;

use App\Rules\UniqueMonthlyBillRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreMonthlyBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('monthly_bill_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bill_date' => [
                'required',
                'date_format:'.config('panel.date_format'),
                new UniqueMonthlyBillRequest(request()->input('bill_date'), request()->input('membership_no'))
            ],
            'membership_no' => [
                'string',
                'required',
            ],
            'billing_amount' => [
                'required',
                'integer',
                'min:-200000',
                'max:2000000',
            ],
        ];
    }
}
