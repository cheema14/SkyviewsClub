<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMenuRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Menu::query()->select(sprintf('%s.*', (new Menu)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'menu_show';
                $editGate = 'menu_edit';
                $deleteGate = 'menu_delete';
                $crudRoutePart = 'menus';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('summary', function ($row) {
                return $row->summary ? $row->summary : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.menus.index');
    }

    public function create()
    {
        abort_if(Gate::denies('menu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');
        
        return view('admin.menus.create',compact('roles'));
    }

    public function store(StoreMenuRequest $request)
    {
        
        // $validator = Validator::make($request->all(), [
        //     'roles' => ['required', 'array'],
        //     'roles.*' => ['exists:roles,id'],
        // ]);
        
        // if ($validator->fails()) {
        // }
        // dd($validator->errors());

        $menu = Menu::create($request->all());
        
        // To associate the tenant id
        // 1- Create a new Model and use the BelongsToTenant trait
        // 2- Or use the below option to manually add tenant IDs to the pivot tables

        // For pivot tables, BelongsToTenant will only work for the Parent Models.
        // In that case it will only work for the Role and Menu models but not 
        // for the menu_role table.


        $roles = $request->input('roles', []); 

        foreach ($roles as $roleId) {
            $menu->roles()->attach($roleId, [
                'tenant_id' => tenant('id'),
            ]);
        }
        return redirect()->route('admin.menus.index')->with('created', 'New Menu Added.');
    }

    public function edit(Menu $menu)
    {
        abort_if(Gate::denies('menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.menus.edit', compact('menu','roles'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->all());

        $menu->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.menus.index')->with('updated', 'Menu Updated.');
    }

    public function show(Menu $menu)
    {
        abort_if(Gate::denies('menu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->load('menuItems');

        return view('admin.menus.show', compact('menu'));
    }

    public function destroy(Menu $menu)
    {
        abort_if(Gate::denies('menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->delete();

        return back()->with('deleted', 'Menu Deleted.');
    }

    public function massDestroy(MassDestroyMenuRequest $request)
    {
        $menus = Menu::find(request('ids'));

        foreach ($menus as $menu) {
            $menu->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
