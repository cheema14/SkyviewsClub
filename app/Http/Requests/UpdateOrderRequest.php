<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    // public function rules()
    // {
    //     return [
    //         'item_discount' => [
    //             'nullable',
    //             'numeric',
    //         ],
    //         'sub_total' => [
    //             'nullable',
    //             'numeric',
    //         ],
    //         'tax' => [
    //             'nullable',
    //             'numeric',
    //         ],
    //         'total' => [
    //             'nullable',
    //             'numeric',
    //         ],
    //         'promo' => [
    //             'string',
    //             'nullable',
    //         ],
    //         'discount' => [
    //             'nullable',
    //             'numeric',
    //         ],
    //         'grand_total' => [
    //             'nullable',
    //             'numeric',
    //         ],

    //         'member_id' => [
    //             'required',
    //             'integer',
    //         ],

    //         // 'menu_id' => [
    //         //     'required',
    //         //     'integer',
    //         // ],
    //         // 'category_id' => [
    //         //     'required',
    //         //     'integer',
    //         // ],
    //         'items.*.price' => [
    //             'required',
    //         ],
    //         'items.*.item_id' => [
    //             'required',
    //             'integer',
    //         ],
    //         'items.*.quantity' => [
    //             'required',
    //             'integer',
    //         ],
    //         'items' => [
    //             'required',
    //             'array',
    //         ],
    //         'status' => [
    //             'required',
    //         ],
    //         'no_of_guests' => [
    //             'required',
    //             'numeric'
    //         ],
    //         'table_top_id' => [
    //             'required',
    //             'integer'
    //         ]
    //     ];
    // }
    public function rules()
    {
        
        if ($this->order && $this->order->status != 'Complete') {
            $rules = [
                // These fields are optional (nullable) but must be numeric if present
                'item_discount' => ['nullable', 'numeric'],
                'sub_total' => ['nullable', 'numeric'],
                'tax' => ['nullable', 'numeric'],
                'total' => ['nullable', 'numeric'],
                'promo' => ['nullable', 'string'],
                'discount' => ['nullable', 'numeric'],
                'grand_total' => ['nullable', 'numeric'],

                // These fields are always required
                'member_id' => ['required', 'integer'],
                'status' => ['required'],
                'no_of_guests' => ['required', 'numeric'],
                'table_top_id' => ['required', 'integer'],

                // The items array is required unless the order status is "Complete"
                'items' => ['required', 'array'],
                'items.*.price' => ['required'],
                'items.*.item_id' => ['required', 'integer'],
                'items.*.quantity' => ['required', 'integer'],
            ];
        }
        
        if ($this->order && $this->order->status === 'Complete') {
            // If the order status is "Complete", make the items array optional
            $rules['items'] = ['nullable', 'array'];
            $rules['items.*.price'] = ['nullable'];
            $rules['items.*.item_id'] = ['nullable', 'integer'];
            $rules['items.*.quantity'] = ['nullable', 'integer'];
        }

        // Check if we are only changing the payment method
        if ($this->input('payment_method') !== null && count($this->only(['payment_method'])) === 1) {
            // If only payment_method is present, return minimal rules
            $rules['payment_method'] = ['required','string'];
            // return [
            //     'payment_method' => ['required', 'string'],
            // ];
            return $rules;
        }

        

        return $rules;
    }

}
