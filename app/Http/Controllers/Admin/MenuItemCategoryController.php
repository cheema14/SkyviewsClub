<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMenuItemCategoryRequest;
use App\Http\Requests\StoreMenuItemCategoryRequest;
use App\Http\Requests\UpdateMenuItemCategoryRequest;
use App\Models\Menu;
use App\Models\MenuItemCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MenuItemCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('menu_item_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            // $query = MenuItemCategory::query()->select(sprintf('%s.*', (new MenuItemCategory)->table));
            $query = MenuItemCategory::with(['menus'])->select(sprintf('%s.*', (new MenuItemCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'menu_item_category_show';
                $editGate = 'menu_item_category_edit';
                $deleteGate = 'menu_item_category_delete';
                $crudRoutePart = 'menu-item-categories';

                return view('partials.'.tenant()->id.'.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->editColumn('menu', function ($row) {
                $labels = [];
                foreach ($row->menus as $menu) {
                    $labels[] = sprintf('<span class="badge badge-info">%s</span>', $menu->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'menu']);

            return $table->make(true);
        }

        return view('admin.menuItemCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('menu_item_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id');

        return view('admin.menuItemCategories.create', compact('menus'));
    }

    public function store(StoreMenuItemCategoryRequest $request)
    {
        $menuItemCategory = MenuItemCategory::create($request->all());
        // dd($request->all());
        $menuItemCategory->menus()->sync($request->input('menus', []));

        return redirect()->route('admin.menu-item-categories.index')->with('created', 'New Menu Item Category Added.');
    }

    public function edit(MenuItemCategory $menuItemCategory)
    {
        abort_if(Gate::denies('menu_item_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id');

        return view('admin.menuItemCategories.edit', compact('menuItemCategory', 'menus'));
    }

    public function update(UpdateMenuItemCategoryRequest $request, MenuItemCategory $menuItemCategory)
    {
        $menuItemCategory->update($request->all());
        $menuItemCategory->menus()->sync($request->input('menus', []));

        return redirect()->route('admin.menu-item-categories.index')->with('updated', 'Menu Item Category Updated.');
    }

    public function show(MenuItemCategory $menuItemCategory)
    {
        abort_if(Gate::denies('menu_item_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menuItemCategory->load('menuItemCategoryItems');

        return view('admin.menuItemCategories.show', compact('menuItemCategory'));
    }

    public function destroy(MenuItemCategory $menuItemCategory)
    {
        abort_if(Gate::denies('menu_item_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menuItemCategory->delete();

        return back()->with('deleted', 'Menu Item Category Deleted.');
    }

    public function massDestroy(MassDestroyMenuItemCategoryRequest $request)
    {
        $menuItemCategories = MenuItemCategory::find(request('ids'));

        foreach ($menuItemCategories as $menuItemCategory) {
            $menuItemCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
