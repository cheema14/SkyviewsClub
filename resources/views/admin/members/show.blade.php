@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <div class="row min-vh-100 custom-table-padding px-0 m-0 w-100">
        <div class="col-lg-3 col-md-12 col-sm-12 custom-mb px-0">
            <div class="side-bar h-100 bg-white">
                <div class="side-bar-content">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="flex-shrink-0">
                            <div class="member-img-box">
                                <img src="{{ $member->photo?->getUrl('preview') ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($member->name) }}" alt="Member Image" class="img-fluid">
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            {{-- <img src="{{ $member->photo?->getUrl('thumb') ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($member->name) }}" class="img-fluid" alt=""> --}}
                            <p class=" sbc-name mt-3 mb-0">{{ $member->name }}</p>
                            <p class=" sbc-desig mb-0">{{ $member->designation->title ?? '' }}</p>
                            <p>{{ App\Models\Member::BPS_SELECT[$member->bps] ?? '' }}</p>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="my-2 d-flex align-items-center justify-content-center flex-column w-100 pl-3">
                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/add.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4"><i class="fa fa-info-circle text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b> Membership Status</b></p>
                                    <h6 class="mb-0">{{ $member->membership_status ? : 'N/A' }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/add.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4"><i class="fa fa-phone text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b> Office Telephone</b></p>
                                    <h6 class="mb-0">{{ $member->telephone_off ? : 'N/A' }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/block.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4" style="font-size: 25px;"><i class="fa fa-mobile text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b>Mobile</b></p>
                                    <h6 class="mb-0">{{ $member->cell_no ? : 'N/A' }}</h6>
                                </div>
                            </div>
                        </div>

                        <hr class="divider">
                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/user.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4"><i class="fa fa-envelope text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b>Email</b></p>
                                    <h6 class="mb-0">{{ $member->email_address }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/scraps.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4"><i class="fa fa-id-card text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b>CNIC</b></p>
                                    <h6 class="mb-0">{{ $member->cnic_no }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/gallery.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4" style="font-size: 25px;"><i class="fa fa-map-marker text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b>Mailing address</b></p>
                                    <h6 class="mb-0">{{ $member->mailing_address }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center w-100 flex-wrap">
                            {{-- <img src="{{ asset('img/depoiments.svg')}}" class="mr-2" alt=""> --}}
                            <div class="d-flex align-items-center">
                                <span class="mr-4" style="font-size: 25px;"><i class="fa fa-male text-theme" aria-hidden="true"></i></span>
                                <div class="d-flex flex-column">
                                    <p class="sbc-text mb-0"><b>Gender</b></p>
                                    <h6 class="mb-0">{{ App\Models\Member::GENDER_SELECT[$member->gender] ?? '' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 pr-0">
            <div class="right-bar bg-white rounded-4 p-4 h-100">
                <ul class="nav nav-tabs members-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">General Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dependents Information</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h4 class="mb-3">Personal Information</h4>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Father name</p>
                                        <p class="mb-0 rb-title">{{ $member->husband_father_name }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Date of Birth</p>
                                        <p class="mb-0 rb-title">{{ $member->date_of_birth }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Qualification</p>
                                        <p class="mb-0 rb-title">{{ $member->qualification }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Nationality</p>
                                        <p class="mb-0 rb-title">{{ $member->nationality }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Station city</p>
                                        <p class="mb-0 rb-title">{{ $member->station_city }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Department</p>
                                        <p class="mb-0 rb-title">{{ $member->department->name ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">PAK Svc No.</p>
                                        <p class="mb-0 rb-title">{{ $member->pak_svc_no }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Present status</p>
                                        <p class="mb-0 rb-title">{{ App\Models\Member::PRESENT_STATUS_SELECT[$member->present_status] ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Permanent address</p>
                                        <p class="mb-0 rb-title">{{ $member->permanent_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h4 class="mb-3">Membership Information</h4>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Membership No.</p>
                                        <p class="mb-0 rb-title">{{ $member->membership_no }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Membership category</p>
                                        <p class="mb-0 rb-title">{{ $member->membership_category->name ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Membership type</p>
                                        <p class="mb-0 rb-title">{{ $member->membership_type->name ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Date of membership</p>
                                        <p class="mb-0 rb-title">{{ $member->date_of_membership }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Golf handicap</p>
                                        <p class="mb-0 rb-title">{{ App\Models\Member::GOLF_H_CAP_SELECT[$member->golf_h_cap] ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <p class="rb-dept mb-0">Membership fee</p>
                                        <p class="mb-0 rb-title">{{ $member->membership_fee }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <p class="rb-dept mb-0">Arrears</p>
                                        <p class="mb-0 rb-title">{{ $member->arrears ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h4 class="mb-3">Special Instructions</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="mb-0 rb-title font-weight-normal">{{ $member->special_instructions }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h4 class="mb-3">Document Information</h4>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0">Signature</p>
                                        <p class="mb-0 rb-title">
                                            <a target="_blank" href="{{ $member->signature?->getUrl() }}">
                                                <img src="{{ $member->signature?->getUrl('thumb') }}" class="img-fluid" alt="">
                                            </a>
                                        </p>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <p class="rb-dept mb-0"> CNIC</p>
                                        <p class="mb-0 rb-title">
                                            <a target="_blank" href="{{ $member->cnic_front?->getUrl() }}">
                                                <img src="{{ $member->cnic_front?->getUrl('thumb') }}" class="img-fluid" alt="">
                                            </a>
                                            <a target="_blank" href="{{ $member->cnic_back?->getUrl() }}">
                                                <img src="{{ $member->cnic_back?->getUrl('thumb') }}" class="img-fluid" alt="">
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive mt-3">
                            <table class="table table-borderless table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date of Birth</th>
                                        <th scope="col">Relation</th>
                                        <th scope="col">Occupation</th>
                                        <th scope="col">Nationality</th>
                                        <th scope="col">Golf hcap</th>
                                        <th scope="col">Allow Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($member?->dependents as $dependent )
                                    <tr>
                                        <td><img src="{{ $dependent->photo?->getUrl('thumb') ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($dependent->name) }}" class="img-thumbnail h-auto border-none " alt="">
                                        </td>
                                        <td>{{ $dependent->name }}</td>
                                        <td>{{ $dependent->dob }}</td>
                                        <td>{{ $dependent->relation }}</td>
                                        <td>{{ $dependent->occupation }}</td>
                                        <td>{{ $dependent->nationality }}</td>
                                        <td>{{ $dependent->golf_hcap }}</td>
                                        <td>{{ $dependent->allow_credit }}</td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="card" style="display:none !important;">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#member_orders" role="tab" data-toggle="tab">
                {{ trans('cruds.order.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="member_orders">
            @includeIf('admin.members.relationships.memberOrders', ['orders' => $member->memberOrders])
        </div>
    </div>
</div>



@endsection
