<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStoreRequest;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stores = Store::all();

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        abort_if(Gate::denies('store_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stores.create');
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Store::create($request->all());

        return redirect()->route('admin.stores.index')->with('created', 'New Store Added.');
    }

    public function edit(Store $store)
    {
        abort_if(Gate::denies('store_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stores.edit', compact('store'));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store->update($request->all());

        return redirect()->route('admin.stores.index')->with('updated', 'Store Updated.');
    }

    public function destroy(Store $store)
    {
        abort_if(Gate::denies('store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $store->delete();

        return back()->with('deleted', 'Store Deleted.');
    }

    public function massDestroy(MassDestroyStoreRequest $request)
    {
        $stores = Store::find(request('ids'));

        foreach ($stores as $store) {
            $store->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
