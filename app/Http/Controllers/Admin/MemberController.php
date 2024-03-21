<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {

        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            
            $query = Member::with(['designation', 'department', 'membership_category', 'membership_type'])->where('is_non_member', '=', 0)->select(sprintf('%s.*', (new Member)->table));
            $table = Datatables::of($query);
            
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->addColumn('status_color', ' ');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'member_show';
                $editGate = 'member_edit';
                $deleteGate = 'member_delete';
                $showDependents = 'dependent_list';
                $viewBill = 'view_bill';
                $crudRoutePart = 'members';

                return view('partials.memberDataTableActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'showDependents',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('membership_no', function ($row) {
                return $row->membership_no ? $row->membership_no : '';
            });
            $table->editColumn('cnic_no', function ($row) {
                return $row->cnic_no ? $row->cnic_no : '';
            });
            
            $table->editColumn('membership_category.name', function ($row) {
                return $row->membership_category ? $row->membership_category->name : '';
            });

            $table->editColumn('membership_type.name', function ($row) {
                return $row->membership_type ? $row->membership_type->name : '';
            });

            $table->editColumn('husband_father_name', function ($row) {
                return $row->husband_father_name ? $row->husband_father_name : '';
            });

            $table->editColumn('status_color', function ($row) {
                return $row->membership_status && Member::STATUS_COLOR[$row->membership_status] ? Member::STATUS_COLOR[$row->membership_status] : 'none';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        
        return view('admin.members.index');
    }

    public function loadServingMembers(Request $request)
    {
        // dd("here");
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Member::where('is_non_member', '=', 1)->select(sprintf('%s.*', (new Member)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->addColumn('status_color', ' ');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'member_show';
                $editGate = 'member_edit';
                $deleteGate = 'member_delete';
                $showDependents = 'dependent_list';
                $viewBill = 'view_bill';
                $crudRoutePart = 'members';

                return view('partials.memberDataTableActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'showDependents',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('membership_no', function ($row) {
                return $row->membership_no ? $row->membership_no : '';
            });
            $table->editColumn('serving_officer_type', function ($row) {
                return $row->serving_officer_type ? $row->serving_officer_type : '';
            });

            $table->filterColumn('serving_officer_type', function ($query, $keyword) {
                $query->where('serving_officer_type', 'like', '%'.$keyword.'%');
            });

            $table->editColumn('husband_father_name', function ($row) {
                return $row->husband_father_name ? $row->husband_father_name : '';
            });

            $table->editColumn('status_color', function ($row) {
                return $row->membership_status && Member::STATUS_COLOR[$row->membership_status] ? Member::STATUS_COLOR[$row->membership_status] : 'none';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.members.serving_members');
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $membership_categories = MembershipCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $membership_types = MembershipType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.members.create', compact('departments', 'designations', 'membership_categories', 'membership_types'));
    }

    public function store(StoreMemberRequest $request)
    {

        $member = Member::create($request->all());

        if ($request->input('photo', false)) {
            $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($request->input('signature', false)) {
            $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('signature'))))->toMediaCollection('signature');
        }

        if ($request->input('cnic_front', false)) {
            $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('cnic_front'))))->toMediaCollection('cnic_front');
        }

        if ($request->input('cnic_back', false)) {
            $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('cnic_back'))))->toMediaCollection('cnic_back');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $member->id]);
        }

        return redirect()->route('admin.members.index')->with('created', 'New Member Added.');
    }

    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $membership_categories = MembershipCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $membership_types = MembershipType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $member->load('designation', 'department', 'membership_category', 'membership_type');

        return view('admin.members.edit', compact('departments', 'designations', 'member', 'membership_categories', 'membership_types'));
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->all());

        if ($request->input('photo', false)) {
            if (! $member->photo || $request->input('photo') !== $member->photo->file_name) {
                if ($member->photo) {
                    $member->photo->delete();
                }
                $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($member->photo) {
            $member->photo->delete();
        }

        if ($request->input('signature', false)) {
            if (! $member->signature || $request->input('signature') !== $member->signature->file_name) {
                if ($member->signature) {
                    $member->signature->delete();
                }
                $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('signature'))))->toMediaCollection('signature');
            }
        } elseif ($member->signature) {
            $member->signature->delete();
        }

        if ($request->input('cnic_front', false)) {
            if (! $member->cnic_front || $request->input('cnic_front') !== $member->cnic_front->file_name) {
                if ($member->cnic_front) {
                    $member->cnic_front->delete();
                }
                $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('cnic_front'))))->toMediaCollection('cnic_front');
            }
        } elseif ($member->cnic_front) {
            $member->cnic_front->delete();
        }

        if ($request->input('cnic_back', false)) {
            if (! $member->cnic_back || $request->input('cnic_back') !== $member->cnic_back->file_name) {
                if ($member->cnic_back) {
                    $member->cnic_back->delete();
                }
                $member->addMedia(storage_path('tmp/uploads/'.basename($request->input('cnic_back'))))->toMediaCollection('cnic_back');
            }
        } elseif ($member->cnic_back) {
            $member->cnic_back->delete();
        }

        return redirect()->route('admin.members.index')->with('updated', 'Member Updated.');
    }

    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $member->load('designation', 'department', 'membership_category', 'membership_type', 'memberOrders');

        return view('admin.members.show', compact('member'));
    }

    public function destroy(Member $member)
    {
        abort_if(Gate::denies('member_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $member->delete();

        return back()->with('deleted', 'Member Deleted.');
    }

    public function massDestroy(MassDestroyMemberRequest $request)
    {
        $members = Member::find(request('ids'));

        foreach ($members as $member) {
            $member->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('member_create') && Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Member();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function get_member_name(Request $request)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [];
        if (! $request->membershipNumber) {
            $data = 'Not Item Found!';
        } else {
            $data = Member::where('membership_no', $request->membershipNumber)
                ->where('serving_officer_type', null)
                ->with('dependents') // Eager load the "dependents" relationship
                ->first();
            $data['color'] = $data->membership_status && Member::STATUS_COLOR[$data->membership_status] ? Member::STATUS_COLOR[$data->membership_status] : 'none';
        }

        return response()->json(['memberInfo' => $data]);

    }
}
