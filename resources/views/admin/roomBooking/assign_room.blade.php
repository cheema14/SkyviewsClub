@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.roomBooking.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roomBooking.listAllBookings') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <label class="" for="member_name">{{ trans(tenant()->id.'/cruds.member.fields.name') }}</label>
                    <strong><p>{{ $roomBooking->member?->name }} </p></strong>
                </div>

                <div class="col-md-3">
                    <label class="" for="membership_no">{{ trans(tenant()->id.'/cruds.member.fields.membership_no') }}</label>
                    <strong><p>{{ $roomBooking->member?->membership_no }} </p></strong>
                </div>

                <div class="col-md-3">
                    <label class="" for="checkin_date">{{ trans(tenant()->id.'/cruds.roomBooking.fields.checkin_date') }}</label>
                    <strong><p>{{ $roomBooking->checkin_date }} </p></strong>
                </div>

                <div class="col-md-3">
                    <label class="" for="checkout_date">{{ trans(tenant()->id.'/cruds.roomBooking.fields.checkout_date') }}</label>
                    <strong><p>{{ $roomBooking->checkout_date }} </p></strong>
                </div>
            </div>

            <form method="POST" action="{{ route("admin.roomBooking.saveBooking",$roomBooking->id) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row">

                    
                    <div class="form-group col-md-6">
                        <label class="" for="room">{{ trans(tenant()->id.'/cruds.roomBooking.fields.room') }}</label>
                        <select class="form-control {{ $errors->has('room_id') ? 'is-invalid' : '' }}" name="room_id" id="room_id" required>
                            <option value="" disabled selected>Select Room</option>
                            @foreach($available_rooms as $id => $entry)            
                                @if ($entry->is_reserved == 0 && $roomBooking->manual_booking == 0)
                                    <option value="{{ $entry->id }}" {{ old('room_id') == $entry->id ? 'selected' : '' }}>{{ $entry->room_title }}</option>
                                @else
                                    <option value="{{ $entry->id }}" {{ $roomBooking->room_id == $entry->id ? 'selected' : '' }}>{{ $entry->room_title }} - Discount: {{ $roomBooking->discount }}</option>
                                @endif
                            @endforeach
                        </select>    
                    </div>

                    
                    @if ($roomBooking->member?->membership_no == 'roombooker')
                        <div class="form-group col-md-6">
                            <label class="" for="room">{{ trans(tenant()->id.'/cruds.roomBooking.fields.members_list') }}</label>
                            <select class="form-control select2 {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" name="membership_no" id="membership_no" required>
                                <option value="" disabled selected>Select Member</option>
                                @foreach($members_list as $id => $member)            
                                    <option value="{{ $member->id }}" {{ old('membership_no') == $member->id ? 'selected' : '' }}>{{ $member->name }} - {{ $member->membership_no }}</option>
                                @endforeach
                            </select>
                            <p style="color:red">This booking was placed by an admin. So a member should be assigned to proceed.</p>    
                        </div>    
                    @endif
                    
                </div>

                    {{-- <input type="hidden" name="roomBooking" value="{{ $roomBooking }}" > --}}
                    
                
                <div class="form-group">
                    <button class="btn btn-success px-5" type="submit">
                        {{ trans(tenant()->id.'/cruds.roomBooking.fields.book_room') }}
                    </button>
                </div>
            </form>
            
            {{-- <br /><br />
            {{ $roomBooking }}
            <br /><br />
            {{ $roomBooking->member }} --}}
        </div>
    </div>
</div>



@endsection