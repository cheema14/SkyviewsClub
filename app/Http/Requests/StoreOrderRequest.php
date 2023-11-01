<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_create');
    }

    public function rules()
    {
        return [

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
            // 'items.*' => [
            //     'integer',
            // ],
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
