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

    public function rules()
    {
        return [
            'item_discount' => [
                'nullable',
                'numeric',
            ],
            'sub_total' => [
                'nullable',
                'numeric',
            ],
            'tax' => [
                'nullable',
                'numeric',
            ],
            'total' => [
                'nullable',
                'numeric',
            ],
            'promo' => [
                'string',
                'nullable',
            ],
            'discount' => [
                'nullable',
                'numeric',
            ],
            'grand_total' => [
                'nullable',
                'numeric',
            ],

            'member_id' => [
                'required',
                'integer',
            ],

            // 'menu_id' => [
            //     'required',
            //     'integer',
            // ],
            // 'category_id' => [
            //     'required',
            //     'integer',
            // ],
            'items.*.price' => [
                'required',
            ],
            'items.*.item_id' => [
                'required',
                'integer',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
            ],
            'items' => [
                'required',
                'array',
            ],
            'status' => [
                'required',
            ],
            'no_of_guests' => [
                'required',
                'numeric'
            ],
            'table_top_id' => [
                'required',
                'integer'
            ]
        ];
    }
}
