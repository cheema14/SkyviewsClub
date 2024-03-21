<?php

namespace App\Http\Requests;

use App\Models\Bill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentReceiptRequest extends FormRequest
{

    public function keyString(): string {
        return implode(',', array_keys(\App\Models\PaymentReceipt::PAY_MODE));
    }  
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create_bill_receipt');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        

        return [
            // 'membership_no' => [
            //     'required',
            // ],
            'receipt_no' => [
                'required',
            ],
            'receipt_date' => [
                'required',
            ],
            'bill_type' => [
                'required',
            ],
            'billing_month' => [
                'required',
            ],
            'invoice_number' => [
                'required',
            ],
            'invoice_amount' => [
                'required',
                'numeric',
                'exists:bills,total'
            ],
            'pay_mode' => [
                'required',
                'in:'.$this->keyString(),
            ],
            'received_amount' => [
                'required',
                'numeric',
            ],
            'cheque_number' => [
                'required_if:pay_mode,Cheque|string',
            ],
            'bank_name' => [
                'required_if:pay_mode,Cheque|string',
            ],
            'cheque_date' => [
                'required_if:pay_mode,Cheque|date',
            ],
            'deposit_slip_number' => [
                'required_if:pay_mode,OnlineTransfer|string',
            ],
            'deposit_bank_name' => [
                'required_if:pay_mode,OnlineTransfer|string',
            ],
            'deposit_date' => [
                'required_if:pay_mode,OnlineTransfer|date',
            ],
        ];
    }

    public function messages()
    {
        return [
            'pay_mode.in' => 'The pay mode must be one of:'.$this->keyString(),
            'invoice_amount.exists' => 'The :attribute (:value) is not equal to actual invoice amount',
        ];
    }

    
}
