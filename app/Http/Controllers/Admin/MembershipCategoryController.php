<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyMembershipCategoryRequest;
use App\Http\Requests\StoreMembershipCategoryRequest;
use App\Http\Requests\UpdateMembershipCategoryRequest;
use App\Models\MembershipCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MembershipCategoryController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('membership_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $membershipCategories = MembershipCategory::all();

        return view('admin.membershipCategories.index', compact('membershipCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('membership_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.membershipCategories.create');
    }

    public function store(StoreMembershipCategoryRequest $request)
    {
        $membershipCategory = MembershipCategory::create($request->all());

        return redirect()->route('admin.membership-categories.index')->with('created', 'New Membership Category Added.');
    }

    public function edit(MembershipCategory $membershipCategory)
    {
        abort_if(Gate::denies('membership_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.membershipCategories.edit', compact('membershipCategory'));
    }

    public function update(UpdateMembershipCategoryRequest $request, MembershipCategory $membershipCategory)
    {
        $membershipCategory->update($request->all());

        return redirect()->route('admin.membership-categories.index')->with('updated', 'Membership Category Updated.');
    }

    public function destroy(MembershipCategory $membershipCategory)
    {
        abort_if(Gate::denies('membership_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $membershipCategory->delete();

        return back()->with('deleted', 'Membership Category Deleted.');
    }

    public function massDestroy(MassDestroyMembershipCategoryRequest $request)
    {
        $membershipCategories = MembershipCategory::find(request('ids'));

        foreach ($membershipCategories as $membershipCategory) {
            $membershipCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
