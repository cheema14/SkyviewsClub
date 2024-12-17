<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class UpdateMonthlyBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('monthly_bill_edit');
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
            ],
            'membership_no' => [
                'string',
                'required',
            ],
            'billing_amount' => [
                'required',
                'numeric',
                // 'gte:'.$this->monthlyBill->billing_amount
            ],
        ];
    }
}
