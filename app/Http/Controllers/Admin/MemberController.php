<?php

namespace App\Http\Controllers\Admin;

use App\Events\DiscountedMembershipFeeEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AbsenteeMemberTrait;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DiscountedMembershipFee;
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
    use MediaUploadingTrait, CsvImportTrait, AbsenteeMemberTrait;

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

                return view('/partials.'.tenant()->id.'.memberDataTableActions', compact(
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

                return view('partials.'.tenant()->id.'.memberDataTableActions', compact(
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

    public function load_absentees_members(Request $request){
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Member::with(['membership_category','discountedMembershipFees'])->where('monthly_type', '=', 'Absentees')->select(sprintf('%s.*', (new Member)->table));
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

                return view('partials.'.tenant()->id.'.memberDataTableActions', compact(
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
            
            $table->editColumn('membership_category.name', function ($row) {
                return $row->membership_category ? $row->membership_category->name : '';
            });
            
            $table->editColumn('discounted_membership_fees.implemented_from', function ($row) {
                return $row->discounted_membership_fees ? $row->discounted_membership_fees->implemented_from : '';
            });
            

            $table->editColumn('status_color', function ($row) {
                return $row->membership_status && Member::STATUS_COLOR[$row->membership_status] ? Member::STATUS_COLOR[$row->membership_status] : 'none';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.members.absentees_members');
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::pluck('title', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $membership_categories = MembershipCategory::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $membership_types = MembershipType::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        return view('admin.members.create', compact('departments', 'designations', 'membership_categories', 'membership_types'));
    }

    public function store(StoreMemberRequest $request)
    {

        
        $member = Member::create($request->all());

        if($request->discount_on_membership_fee){
            $data['discount_on_membership_fee'] = $request->discount_on_membership_fee;
            $data['column'] = 'discount_on_membership_fee';
            $data['member_id'] = $member->id;
            DiscountedMembershipFeeEvent::dispatch($data);
        }
        // Now we can store the information 
        // for the discounted subscription fee
        
        $discounted_membership_fee = new DiscountedMembershipFee();
        
        $discounted_membership_fee->monthly_subscription_revised = $request->monthly_subscription_revised;
        $discounted_membership_fee->no_of_months = $request->no_of_months;
        $discounted_membership_fee->member_id = $member->id;
        $discounted_membership_fee->implemented_from = date('Y-m-d');
        $discounted_membership_fee->remaining_months = $request->no_of_months;
        $discounted_membership_fee->is_active = 1;
        $discounted_membership_fee->save();
        
        $tenant_id = tenant()->id;
        // tenancy()->central(function () use ($employee, $request,$tenant_id) {
        //     if ($request->input('employee_photo',false)) {
        //         $employee->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('employee_photo'))))->toMediaCollection('employee_photo', 'employees');
        //     }
        // });

        
        tenancy()->central(function () use ($member, $request,$tenant_id,$discounted_membership_fee) {
            
            if ($request->input('photo',false)) {
                $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('photo'))))->toMediaCollection('photo','members');
            }

            if($discounted_membership_fee){
                if ($request->input('absentees_application', false)) {
                    $discounted_membership_fee->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('absentees_application'))))->toMediaCollection('absentees_application','absentees');
                }
            }
    
            if ($request->input('signature', false)) {
                $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('signature'))))->toMediaCollection('signature','signature');
            }
    
            if ($request->input('cnic_front', false)) {
                $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('cnic_front'))))->toMediaCollection('cnic_front','cnic');
            }
    
            if ($request->input('cnic_back', false)) {
                $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('cnic_back'))))->toMediaCollection('cnic_back','cnic');
            }
        });
        
        
        
        // $member->load('media');

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $member->id]);
        }

        return redirect()->route('admin.members.index')->with('created', 'New Member Added.');
    }

    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::pluck('title', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $membership_categories = MembershipCategory::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $membership_types = MembershipType::pluck('name', 'id')->prepend(trans(tenant()->id.'/global.pleaseSelect'), '');

        $member->load('designation', 'department', 'membership_category', 'membership_type','discountedMembershipFees');
        
        return view('admin.members.edit', compact('departments', 'designations', 'member', 'membership_categories', 'membership_types'));
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        
        $member->update($request->all());

        // We shall use this tenant id in the central domain check
        $tenant_id = tenant()->id;

        $data['discount_on_membership_fee'] = $request->discount_on_membership_fee;
        $data['column'] = 'discount_on_membership_fee';
        $data['member_id'] = $member->id;
        $data['update_call'] = true;
        $data['absentees_monthly_subscription'] = false;
        // DiscountedMembershipFeeEvent::dispatch($data);

        if ($request->input('photo', false)) {
            if (! $member->photo || $request->input('photo') !== $member->photo->file_name) {
                if ($member->photo) {
                    $member->photo->delete();
                }
                tenancy()->central(function () use ($member, $request,$tenant_id) {
                    if ($request->input('photo',false)) {
                        $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('photo'))))->toMediaCollection('photo', 'members');
                    }
                });
            }
        } elseif ($member->photo) {
            $member->photo->delete();
        }

        if ($request->input('signature', false)) {
            if (! $member->signature || $request->input('signature') !== $member->signature->file_name) {
                if ($member->signature) {
                    $member->signature->delete();
                }
                tenancy()->central(function () use ($member, $request,$tenant_id) {
                    if ($request->input('signature',false)) {
                        $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('signature'))))->toMediaCollection('signature', 'signature');
                    }
                });
            }
        } elseif ($member->signature) {
            $member->signature->delete();
        }

        if ($request->input('cnic_front', false)) {
            if (! $member->cnic_front || $request->input('cnic_front') !== $member->cnic_front->file_name) {
                if ($member->cnic_front) {
                    $member->cnic_front->delete();
                }
                tenancy()->central(function () use ($member, $request,$tenant_id) {
                    if ($request->input('cnic_front',false)) {
                        $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('cnic_front'))))->toMediaCollection('cnic_front', 'cnic');
                    }
                });
            }
        } elseif ($member->cnic_front) {
            $member->cnic_front->delete();
        }

        if ($request->input('cnic_back', false)) {
            if (! $member->cnic_back || $request->input('cnic_back') !== $member->cnic_back->file_name) {
                if ($member->cnic_back) {
                    $member->cnic_back->delete();
                }
                tenancy()->central(function () use ($member, $request,$tenant_id) {
                    if ($request->input('cnic_back',false)) {
                        $member->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('cnic_back'))))->toMediaCollection('cnic_back', 'cnic');
                    }
                });
            }
        } elseif ($member->cnic_back) {
            $member->cnic_back->delete();
        }

        if($member->monthly_type == 'Absentees'){
            $discounted_membership_fee = $this->update_absentee_monthly_type($request->all(),$member->id);

            if ($request->input('absentees_application', false)) {
                if (! $discounted_membership_fee->absentees_application || $request->input('absentees_application') !== $discounted_membership_fee->absentees_application->file_name) {
                    if ($discounted_membership_fee->absentees_application) {
                        $discounted_membership_fee->absentees_application->delete();
                    }
                    tenancy()->central(function () use ($discounted_membership_fee, $request,$tenant_id) {
                        if ($request->input('absentees_application',false)) {
                            $discounted_membership_fee->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('absentees_application'))))->toMediaCollection('absentees_application', 'absentees');
                        }
                    });
                }
            } elseif ($discounted_membership_fee->cnic_back) {
                $discounted_membership_fee->cnic_back->delete();
            }
            
        }


        return redirect()->route('admin.members.index')->with('updated', 'Member Updated.');
    }

    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $member->load('designation', 'department', 'membership_category', 'membership_type', 'memberOrders');
        
        
        // dd($member->photo);

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
            $data['color'] = $data?->membership_status && Member::STATUS_COLOR[$data?->membership_status] ? Member::STATUS_COLOR[$data?->membership_status] : 'none';
        }

        return response()->json(['memberInfo' => $data]);

    }
}
