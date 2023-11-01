<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyMembershipTypeRequest;
use App\Http\Requests\StoreMembershipTypeRequest;
use App\Http\Requests\UpdateMembershipTypeRequest;
use App\Models\MembershipType;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MembershipTypeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('membership_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $membershipTypes = MembershipType::all();

        return view('admin.membershipTypes.index', compact('membershipTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('membership_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.membershipTypes.create');
    }

    public function store(StoreMembershipTypeRequest $request)
    {
        $membershipType = MembershipType::create($request->all());

        return redirect()->route('admin.membership-types.index')->with('created', 'New Membership Type Added.');
    }

    public function edit(MembershipType $membershipType)
    {
        abort_if(Gate::denies('membership_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.membershipTypes.edit', compact('membershipType'));
    }

    public function update(UpdateMembershipTypeRequest $request, MembershipType $membershipType)
    {
        $membershipType->update($request->all());

        return redirect()->route('admin.membership-types.index')->with('updated', 'Membership Type Updated.');
    }

    public function destroy(MembershipType $membershipType)
    {
        abort_if(Gate::denies('membership_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $membershipType->delete();

        return back()->with('deleted', 'Membership Type Deleted.');
    }

    public function massDestroy(MassDestroyMembershipTypeRequest $request)
    {
        $membershipTypes = MembershipType::find(request('ids'));

        foreach ($membershipTypes as $membershipType) {
            $membershipType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
