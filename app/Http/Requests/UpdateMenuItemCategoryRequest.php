<?php

namespace App\Http\Requests;

use App\Models\MenuItemCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMenuItemCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('menu_item_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'menus.*' => [
                'integer',
            ],
            'menus' => [
                'required',
                'array',
            ],
        ];
    }
}
