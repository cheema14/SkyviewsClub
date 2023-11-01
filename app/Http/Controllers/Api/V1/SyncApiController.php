<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Item;
use App\Models\Menu;
use App\Models\TableTop;
use Illuminate\Http\Request;
use App\Models\MenuItemCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Traits\ApiResponser;
use App\Http\Resources\MenuItemCategoryResource;
use Config;

class SyncApiController extends Controller
{
    /**
     * Handle the incoming request.
     */

    Use ApiResponser;

    public function __invoke(Request $request)
    {


        return $this->success(
            [
                'menu' => MenuResource::collection(Menu::with('menuCategories')->get()) ,
                'menuItemCategories'=> MenuItemCategoryResource::collection(MenuItemCategory::all()) ,
                'menuItems'=> Item::all(),
                'tableTop'=> TableTop::all(),
                'printers' => Config::get('printers')
            ],
            'Synced Successfully',
        );
    }
}
