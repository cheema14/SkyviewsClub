<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyItemRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\Menu;
use App\Models\MenuItemCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Item::with(['menus', 'menu_item_category'])->select(sprintf('%s.*', (new Item)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'item_show';
                $editGate = 'item_edit';
                $deleteGate = 'item_delete';
                $crudRoutePart = 'items';

                return view('partials.datatablesActions', compact(
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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('menu', function ($row) {
                $labels = [];
                foreach ($row->menus as $menu) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $menu->title);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('menu_item_category_name', function ($row) {
                return $row->menu_item_category ? $row->menu_item_category->name : '';
            });

            $table->editColumn('summary', function ($row) {
                return $row->summary ? $row->summary : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'menu', 'menu_item_category']);

            return $table->make(true);
        }

        return view('admin.items.index');
    }

    public function create()
    {
        abort_if(Gate::denies('item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id');

        $menu_item_categories = MenuItemCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.items.create', compact('menu_item_categories', 'menus'));
    }

    public function store(StoreItemRequest $request)
    {
        $item = Item::create($request->all());
        // $item->menus()->sync($request->input('menus', []));

        return redirect()->route('admin.items.index')->with('created', 'New Item Added.');
    }

    public function edit(Item $item)
    {
        abort_if(Gate::denies('item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menus = Menu::pluck('title', 'id');

        $menu_item_categories = MenuItemCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $item->load('menus', 'menu_item_category');

        return view('admin.items.edit', compact('item', 'menu_item_categories', 'menus'));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->all());
        // $item->menus()->sync($request->input('menus', []));

        return redirect()->route('admin.items.index')->with('updated', 'Item Updated.');
    }

    public function show(Item $item)
    {
        abort_if(Gate::denies('item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item->load('menus', 'menu_item_category');

        return view('admin.items.show', compact('item'));
    }

    public function destroy(Item $item)
    {
        abort_if(Gate::denies('item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item->delete();

        return back()->with('deleted', 'Item Deleted.');
    }

    public function massDestroy(MassDestroyItemRequest $request)
    {
        $items = Item::find(request('ids'));

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getItemById(Request $request)
    {

        abort_if(Gate::denies('store_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (! $request->item_id) {
            $data = 'Not Item Found!';
        } else {
            $data = Item::find($request->item_id);
        }

        return response()->json(['item' => $data]);
    }

    public function getItemByMenu(Request $request)
    {

        abort_if(Gate::denies('store_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu = Menu::find($request->menu_id);

        // dd($menu->menuCategories);
    }
}
