@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.create') }} {{ trans('cruds.member.title_singular') }}
        </h4>
    </div>


        <form method="POST" action="{{ route("admin.members.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">


                    <div class="form-group col-md-4">
                        <label class="required" for="name">{{ trans('cruds.member.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="designation_id">{{ trans('cruds.member.fields.designation') }}</label>
                        <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation_id" id="designation_id">
                            @foreach($designations as $id => $entry)
                                <option value="{{ $id }}" {{ old('designation_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('designation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.designation_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ trans('cruds.member.fields.bps') }}</label>
                        <select class="form-control {{ $errors->has('bps') ? 'is-invalid' : '' }}" name="bps" id="bps">
                            <option value disabled {{ old('bps', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Member::BPS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('bps', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('bps'))
                            <div class="invalid-feedback">
                                {{ $errors->first('bps') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.bps_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="department_id">{{ trans('cruds.member.fields.organization') }}</label>
                        <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id">
                            @foreach($departments as $id => $entry)
                                <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('department'))
                            <div class="invalid-feedback">
                                {{ $errors->first('department') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.organization_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pak_svc_no">{{ trans('cruds.member.fields.pak_svc_no') }}</label>
                        <input class="form-control {{ $errors->has('pak_svc_no') ? 'is-invalid' : '' }}" type="number" name="pak_svc_no" id="pak_svc_no" value="{{ old('pak_svc_no', '') }}" step="1">
                        @if($errors->has('pak_svc_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pak_svc_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.pak_svc_no_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ trans('cruds.member.fields.present_status') }}</label>
                        <select class="form-control {{ $errors->has('present_status') ? 'is-invalid' : '' }}" name="present_status" id="present_status">
                            <option value disabled {{ old('present_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Member::PRESENT_STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('present_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('present_status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('present_status') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.present_status_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="date_of_birth">{{ trans('cruds.member.fields.date_of_birth') }}</label>
                        <input  class="form-control birth_date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                        @if($errors->has('date_of_birth'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date_of_birth') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.date_of_birth_helper') }}</span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="date_of_membership">Member Age</label>
                        <input class="form-control" type="text" readonly value="" name="member_age" id="member_age" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nationality">{{ trans('cruds.member.fields.nationality') }}</label>
                        <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', '') }}">
                        @if($errors->has('nationality'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nationality') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.nationality_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="station_city">{{ trans('cruds.member.fields.station_city') }}</label>
                        <input class="form-control {{ $errors->has('station_city') ? 'is-invalid' : '' }}" type="text" name="station_city" id="station_city" value="{{ old('station_city', '') }}">
                        @if($errors->has('station_city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('station_city') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.station_city_helper') }}</span>
                    </div>
                    <div x-data class="form-group col-md-4">
                        <label for="telephone_off">{{ trans('cruds.member.fields.telephone_off') }}</label>
                        <input x-mask="9999-9999999" placeholder="XXXX-XXXXXXX" class="form-control {{ $errors->has('telephone_off') ? 'is-invalid' : '' }}" type="text" name="telephone_off" id="telephone_off" value="{{ old('telephone_off', '') }}">
                        @if($errors->has('telephone_off'))
                            <div class="invalid-feedback">
                                {{ $errors->first('telephone_off') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.telephone_off_helper') }}</span>
                    </div>
                    <div x-data class="form-group col-md-4">
                        <label for="cell_no">{{ trans('cruds.member.fields.cell_no') }}</label>
                        <input x-mask="9999-9999999" placeholder="XXXX-XXXXXXX" class="form-control {{ $errors->has('cell_no') ? 'is-invalid' : '' }}" type="text" name="cell_no" id="cell_no" value="{{ old('cell_no', '') }}">
                        @if($errors->has('cell_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cell_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.cell_no_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="mailing_address">{{ trans('cruds.member.fields.mailing_address') }}</label>
                        <input class="form-control {{ $errors->has('mailing_address') ? 'is-invalid' : '' }}" type="text" name="mailing_address" id="mailing_address" value="{{ old('mailing_address', '') }}">
                        @if($errors->has('mailing_address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('mailing_address') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.mailing_address_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tel_res">{{ trans('cruds.member.fields.tel_res') }}</label>
                        <input class="form-control {{ $errors->has('tel_res') ? 'is-invalid' : '' }}" type="text" name="tel_res" id="tel_res" value="{{ old('tel_res', '') }}">
                        @if($errors->has('tel_res'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tel_res') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.tel_res_helper') }}</span>
                    </div>
                    <div x-data class="form-group col-md-4">
                        <label class="required" for="cnic_no">{{ trans('cruds.member.fields.cnic_no') }}</label>
                        <input x-mask="99999-9999999-9" placeholder="XXXXX-XXXXXXX-X" class="form-control {{ $errors->has('cnic_no') ? 'is-invalid' : '' }}" type="text" name="cnic_no" id="cnic_no" value="{{ old('cnic_no', '') }}" required>
                        @if($errors->has('cnic_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cnic_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.cnic_no_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email_address">{{ trans('cruds.member.fields.email_address') }}</label>
                        <input class="form-control {{ $errors->has('email_address') ? 'is-invalid' : '' }}" type="email" name="email_address" id="email_address" value="{{ old('email_address') }}">
                        @if($errors->has('email_address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email_address') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.email_address_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="required" for="membership_no">{{ trans('cruds.member.fields.membership_no') }}</label>
                        <input class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" type="text" name="membership_no" id="membership_no" value="{{ old('membership_no', '') }}" required>
                        @if($errors->has('membership_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_no_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ trans('cruds.member.fields.gender') }}</label>
                        <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                            <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Member::GENDER_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.gender_helper') }}</span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="permanent_address">{{ trans('cruds.member.fields.permanent_address') }}</label>
                        <input class="form-control {{ $errors->has('permanent_address') ? 'is-invalid' : '' }}" type="text" name="permanent_address" id="permanent_address" value="{{ old('permanent_address', '') }}">
                        @if($errors->has('permanent_address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('permanent_address') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.permanent_address_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="required" for="husband_father_name">{{ trans('cruds.member.fields.husband_father_name') }}</label>
                        <input class="form-control {{ $errors->has('husband_father_name') ? 'is-invalid' : '' }}" type="text" name="husband_father_name" id="husband_father_name" value="{{ old('husband_father_name', '') }}" required>
                        @if($errors->has('husband_father_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('husband_father_name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.husband_father_name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="qualification">{{ trans('cruds.member.fields.qualification') }}</label>
                        <input class="form-control {{ $errors->has('qualification') ? 'is-invalid' : '' }}" type="text" name="qualification" id="qualification" value="{{ old('qualification', '') }}">
                        @if($errors->has('qualification'))
                            <div class="invalid-feedback">
                                {{ $errors->first('qualification') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.qualification_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ trans('cruds.member.fields.golf_h_cap') }}</label>
                        <select class="form-control {{ $errors->has('golf_h_cap') ? 'is-invalid' : '' }}" name="golf_h_cap" id="golf_h_cap">
                            <option value disabled {{ old('golf_h_cap', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Member::GOLF_H_CAP_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('golf_h_cap', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('golf_h_cap'))
                            <div class="invalid-feedback">
                                {{ $errors->first('golf_h_cap') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.golf_h_cap_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="membership_category_id">{{ trans('cruds.member.fields.membership_category') }}</label>
                        <select class="form-control select2 {{ $errors->has('membership_category') ? 'is-invalid' : '' }}" name="membership_category_id" id="membership_category_id">
                            @foreach($membership_categories as $id => $entry)
                                <option value="{{ $id }}" {{ old('membership_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('membership_category'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_category') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_category_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="membership_type_id">{{ trans('cruds.member.fields.membership_type') }}</label>
                        <select class="form-control select2 {{ $errors->has('membership_type') ? 'is-invalid' : '' }}" name="membership_type_id" id="membership_type_id">
                            @foreach($membership_types as $id => $entry)
                                <option value="{{ $id }}" {{ old('membership_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('membership_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_type') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_type_helper') }}</span>
                        <span class="help-block subscription_fee" style="display:none;color:blue">Subscription Fee:</span> <br />
                        <span class="help-block security_fee" style="display:none;color:red">Security Fee:</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="date_of_membership">{{ trans('cruds.member.fields.date_of_membership') }}</label>
                        <input class="form-control date {{ $errors->has('date_of_membership') ? 'is-invalid' : '' }}" type="text" name="date_of_membership" id="date_of_membership" value="{{ old('date_of_membership') }}">
                        @if($errors->has('date_of_membership'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date_of_membership') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.date_of_membership_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="membership_card_issuance">{{ trans('cruds.member.fields.membership_card_issuance') }}</label>
                        <input id="membership_card_issuance" type="date" name="membership_card_issuance" class="form-control" >
                        @if($errors->has('membership_card_issuance'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_card_issuance') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_card_issuance_helper') }}</span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="membership_card_expiry">{{ trans('cruds.member.fields.membership_card_expiry') }}</label>
                        <input id="membership_card_expiry" type="date" name="membership_card_expiry" class="form-control" >
                        @if($errors->has('membership_card_expiry'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_card_expiry') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_card_expiry_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ trans('cruds.member.fields.membership_status') }}</label>
                        <select class="form-control {{ $errors->has('membership_status') ? 'is-invalid' : '' }}" name="membership_status" id="membership_status">
                            <option value disabled {{ old('membership_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Member::MEMBERSHIP_STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('membership_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('membership_status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_status') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_status_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="membership_fee">{{ trans('cruds.member.fields.membership_fee') }}</label>
                        <input class="form-control {{ $errors->has('membership_fee') ? 'is-invalid' : '' }}" type="text" name="membership_fee" id="membership_fee" value="{{ old('membership_fee', '') }}">
                        @if($errors->has('membership_fee'))
                            <div class="invalid-feedback">
                                {{ $errors->first('membership_fee') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.membership_fee_helper') }}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="payment_method">{{ trans('cruds.member.fields.payment_method') }}</label>
                        <select
                        class="form-control {{ $errors->has('payment_method') ? 'is-invalid' : '' }} payment_method" name="payment_method" id="payment_method">
                            <option value="" disabled>Select Payment Method</option>
                            <option value="cash">Only Cash</option>
                            <option value="credit">Only Credit</option>
                            <option value="both">Both</option>
                        </select>
                        @if($errors->has('payment_method'))
                            <div class="invalid-feedback">
                                {{ $errors->first('payment_method') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.payment_method_helper') }}</span>
                    </div>




                    <div class="form-group col-md-4">
                        <label for="organization">{{ trans('cruds.member.fields.lahorebase') }}</label>
                        <select class="form-control select2 {{ $errors->has('organization') ? 'is-invalid' : '' }}" name="organization" id="organization">
                            <option value="" selected disabled>Select Base</option>
                            <option value="Others">Others</option>
                            <option value="Base">Base</option>
                        </select>
                        @if($errors->has('organization'))
                            <div class="invalid-feedback">
                                {{ $errors->first('organization') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.lahorebase_helper') }}</span>
                    </div>




                            <div class="form-group col-md-4">
                                <label for="monthly_type">{{ trans('cruds.member.fields.monthly_type') }}</label>
                                <select
                                class="form-control {{ $errors->has('monthly_type') ? 'is-invalid' : '' }} monthly_type" name="monthly_type" id="monthly_type">
                                    <option value="placeholder">Select Monthly Type</option>
                                    <option value="Absentees">Absentees</option>
                                    <option value="Others">Others</option>
                                </select>
                                @if($errors->has('monthly_type'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('monthly_type') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.monthly_type_helper') }}</span>
                            </div>

                            <div x-data class="form-group col-md-4 monthly_subscription_revised_div" style="display:none;">
                                <label class="required" for="monthly_subscription_revised">{{ trans('cruds.member.fields.monthly_subscription_revised') }}</label>
                                <input x-mask="99999999" placeholder="Enter Subscription Amount" class="form-control {{ $errors->has('monthly_subscription_revised') ? 'is-invalid' : '' }}" type="text" name="monthly_subscription_revised" id="monthly_subscription_revised" value="{{ old('monthly_subscription_revised', '') }}">
                                @if($errors->has('monthly_subscription_revised'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('monthly_subscription_revised') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.cnic_no_helper') }}</span>
                            </div>

                            <div x-data class="form-group col-md-4" >
                                <label class="required" for="arrears">{{ trans('cruds.member.fields.arrears') }}</label>
                                <input x-mask="99999999" placeholder="Enter Arrear Amount" class="form-control {{ $errors->has('arrears') ? 'is-invalid' : '' }}" type="text" name="arrears" id="arrears" value="{{ old('arrears', '') }}">
                                @if($errors->has('arrears'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('arrears') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.arrears_helper') }}</span>
                            </div>

                            <div x-data class="form-group col-md-4" >
                                <label class="" for="member_security_fee">{{ trans('cruds.member.fields.member_security_fee') }}</label>
                                <input x-mask="99999999" placeholder="Enter Security Fee" class="form-control {{ $errors->has('member_security_fee') ? 'is-invalid' : '' }}" type="text" name="member_security_fee" id="member_security_fee" value="{{ old('member_security_fee', '') }}">
                                @if($errors->has('member_security_fee'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('member_security_fee') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.member_security_fee_helper') }}</span>
                            </div>



                            {{-- <div x-data class="form-group col-md-4 monthly_type_extra" >
                                <label class="required" for="monthly_fee">{{ trans('cruds.member.fields.monthly_fee') }}</label>
                                <input x-mask="9999999" placeholder="Enter Monthly Fee" class="form-control {{ $errors->has('monthly_fee') ? 'is-invalid' : '' }}" type="text" name="monthly_fee" id="monthly_fee" value="{{ old('monthly_fee', '') }}" >
                                @if($errors->has('monthly_fee'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('monthly_fee') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.monthly_fee_helper') }}</span>
                            </div>

                            <div x-data class="form-group col-md-4 monthly_type_extra" >
                                <label class="required" for="caddy_welfare_fee">{{ trans('cruds.member.fields.caddy_welfare_fee') }}</label>
                                <input x-mask="9999999" placeholder="Enter Caddy Welfare Fee" class="form-control {{ $errors->has('caddy_welfare_fee') ? 'is-invalid' : '' }}" type="text" name="caddy_welfare_fee" id="caddy_welfare_fee" value="{{ old('caddy_welfare_fee', '') }}" >
                                @if($errors->has('caddy_welfare_fee'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('caddy_welfare_fee') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.caddy_welfare_fee_helper') }}</span>
                            </div>

                            <div x-data class="form-group col-md-4 monthly_type_extra" >
                                <label class="required" for="security_fee">{{ trans('cruds.member.fields.security_fee') }}</label>
                                <input x-mask="9999999" placeholder="Enter Security Fee" class="form-control {{ $errors->has('security_fee') ? 'is-invalid' : '' }}" type="text" name="security_fee" id="security_fee" value="{{ old('security_fee', '') }}" >
                                @if($errors->has('security_fee'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('security_fee') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.member.fields.security_fee_helper') }}</span>
                            </div> --}}

                    <div class="form-group col-md-12">
                        <label for="photo">{{ trans('cruds.member.fields.photo') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                        </div>
                        @if($errors->has('photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.photo_helper') }}</span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="signature">{{ trans('cruds.member.fields.signature') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('signature') ? 'is-invalid' : '' }}" id="signature-dropzone">
                        </div>
                        @if($errors->has('signature'))
                            <div class="invalid-feedback">
                                {{ $errors->first('signature') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.signature_helper') }}</span>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="cnic_front">{{ trans('cruds.member.fields.cnic_front') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('cnic_front') ? 'is-invalid' : '' }}" id="front-dropzone">
                        </div>
                        @if($errors->has('cnic_front'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cnic_front') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.cnic_front_helper') }}</span>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="cnic_back">{{ trans('cruds.member.fields.cnic_back') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('cnic_back') ? 'is-invalid' : '' }}" id="back-dropzone">
                        </div>
                        @if($errors->has('cnic_back'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cnic_back') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.cnic_back_helper') }}</span>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="special_instructions">{{ trans('cruds.member.fields.special_instructions') }}</label>
                        <textarea class="form-control {{ $errors->has('special_instructions') ? 'is-invalid' : '' }}" name="special_instructions" id="special_instructions">{{ old('special_instructions') }}</textarea>
                        @if($errors->has('special_instructions'))
                            <div class="invalid-feedback">
                                {{ $errors->first('special_instructions') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.member.fields.special_instructions_helper') }}</span>
                    </div>
            </div>
            <div class="card-body row" x-data="handler()" >
                <div class="col-md-12" style="display:none;">
                    <label for="photo">Add Dependent(s)</label>
                    <table class="table table-bordered align-items-center table-sm">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Occupation</th>
                            <th>Relation</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Nationality</th>
                            <th>Golf H/Cap</th>
                            <th>Photo</th>
                            <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(field, index) in fields" :key="index">
                                <tr>
                                    <td x-text="index + 1"></td>
                                    <td><input x-model="field.dep_name" id="dep_name" type="text" name="dep_name[]" class="form-control" required></td>
                                    <td><input x-model="field.dep_age" id="dep_age" type="number" name="dep_age[]" class="form-control" required></td>
                                    <td><input x-model="field.dep_occupation" id="dep_occupation" type="text" name="dep_occupation[]" class="form-control" required></td>
                                    <td>
                                        <select class="form-control" name="dep_relation[]" id="dep_relation" required>
                                            <option value="" disabled selected>Select Relation</option>
                                            <option value="Wife">Wife</option>
                                            <option value="Son">Son</option>
                                            <option value="Daughter">Daughter</option>
                                        </select>
                                        <!-- <input x-model="field.dep_relation" id="dep_relation" type="text" name="dep_relation[]" class="form-control"></td> -->
                                    <td><input x-model="field.dep_dob" id="dep_dob" type="date" name="dep_dob[]" class="form-control" required></td>
                                    <td>
                                        <select class="form-control" name="dep_gender[]" id="dep_gender" required>
                                            <option value disabled {{ old('dep_gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Models\Member::GENDER_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ old('dep_gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input x-model="field.dep_nationality" id="dep_nationality" type="text" name="dep_nationality[]" class="form-control" required></td>
                                    <td><input x-model="field.dep_golf_hcap" id="dep_golf_hcap" type="text" name="dep_golf_hcap[]" class="form-control" required></td>
                                    <td >
                                        <input x-model="field.dep_photo" type="file" name="dep_photo[]" id="dep_photo" class="form-control" required>
                                        <!-- <div class="form-group col-md-12">
                                            <label for="photo">{{ trans('cruds.member.fields.dep_photo') }}</label>
                                            <div class="needsclick dropzone {{ $errors->has('dep_photo') ? 'is-invalid' : '' }}" id="dphoto-dropzone">
                                            </div>
                                            @if($errors->has('dep_photo'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('dep_photo') }}
                                                </div>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.member.fields.dep_photo_helper') }}</span>
                                        </div> -->
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Family Member</button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>



                <div class="form-group col-md-6">
                    <button class="btn btn-success px-5 submit_form" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </div>
        </form>

</div>



@endsection

@section('scripts')
<script>

function handler() {

    return {
      fields: [],
      addNewField() {
          this.fields.push({
            dep_name:'',
            dep_age:'',
            dep_occupation:'',
            dep_relation:'',
            dep_dob:'',
            dep_gender:'',
            dep_nationality:'',
            dep_golf_hcap:'',
            dep_photo:'',
           });
        },
        removeField(index) {
           this.fields.splice(index, 1);
         }
      }
 };


</script>
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.members.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
    @if(isset($member) && $member->photo)
        var file = {!! json_encode($member->photo) !!}
            this.options.addedfile.call(this, file)
        this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
    @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }

</script>
<script>
    Dropzone.options.signatureDropzone = {
        url: '{{ route('admin.members.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 2,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').find('input[name="signature"]').remove()
        $('form').append('<input type="hidden" name="signature" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="signature"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
            @if(isset($member) && $member->signature)
            var file = {!! json_encode($member->signature) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="signature" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
    }


    $(document).on("change",".monthly_type",function(event){


        if($(this).val() == 'Absentees'){
            $(".monthly_subscription_revised_div").show();
        }
        else{
            $(".monthly_subscription_revised_div").hide();
        }
    });

    $(document).on("change","#membership_type_id",function(event){
        // console.log("event.target.value="+event.target.value);
        var membership_type = event.target.value;

                $.ajax({
                type:'POST',
                url:'{{ route('admin.membership-types.get-membership-fees') }}',
                headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                    },
                data:{ membership_type: membership_type},
                success:function(data) {

                    var dta = JSON.parse(data);

                    $(".subscription_fee").html('');
                    $(".security_fee").html('');


                    if(dta){
                        $(".subscription_fee").show();
                        $(".security_fee").show();
                        $(".subscription_fee").html('Monthly Fee:'+dta.monthly_fee);
                        $(".security_fee").html('Security Fee:'+dta.security_fee);
                    }
                    else{
                        $(".subscription_fee").hide();
                        $(".security_fee").hide();
                    }
                }
                });
    });

</script>

<script>
     Dropzone.options.dphotoDropzone = {
        url: '{{ route('admin.members.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 2,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').find('input[name="dep_photo"]').remove()
        $('form').append('<input type="hidden" name="dep_photo[]" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="dep_photo[]"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
            @if(isset($member) && $member->dep_photo)
            var file = {!! json_encode($member->dep_photo) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="dep_photo[]" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
    }
</script>

<script>

    //  CNIC Front dropzone
    Dropzone.options.frontDropzone = {
        url: '{{ route('admin.members.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 2,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').find('input[name="cnic_front"]').remove()
        $('form').append('<input type="hidden" name="cnic_front" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="cnic_front"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
            @if(isset($member) && $member->cnic_front)
            var file = {!! json_encode($member->cnic_front) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="cnic_front" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
    }


    // CNIC Back dropdown
    Dropzone.options.backDropzone = {
        url: '{{ route('admin.members.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 2,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').find('input[name="cnic_back"]').remove()
        $('form').append('<input type="hidden" name="cnic_back" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="cnic_back"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
            @if(isset($member) && $member->cnic_back)
            var file = {!! json_encode($member->cnic_back) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="cnic_back" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
    }


</script>


@endsection
