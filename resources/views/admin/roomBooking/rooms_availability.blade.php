@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-body">
        <h1>
            <img src="{{ asset('img/pcom/bed-icon.png') }}"> 
            {{ trans(tenant()->id.'/cruds.roomAvailability.title') }}
        </h1>
                <form action="">
                    <div class="row">
                        
                        <div class="form-group col-md-3">
                            <label for="checkin_date">Checkin Date:</label>
                            <input type="text" name="checkin_date" class="form-control date" value="{{ request('checkin_date') }}">
                        </div>
                    
                        <div class="form-group col-md-3">
                            <label for="checkout_date">Checkout Date:</label>
                            <input type="text" name="checkout_date" class="form-control date" value="{{ request('checkout_date') }}">
                        </div>
                    
                        <div class="form-group col-md-3">
                            <label for="room_category">Booking Category:</label>
                            <select class="form-control select2 {{ $errors->has('room_category') ? 'is-invalid' : '' }}" name="room_category" id="room_category">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($bookingCategories as $category )
                                    <option value="{{ $category->id }}" {{ request('room_category') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('admin.roomAvailability.listRoomAvailability') }}" class="btn btn-danger">Reset</a>
                </form>
                <div class="select-room">
                    <div class="row">
                        @foreach ($all_rooms as $room )
                            {{-- {{ $room->roomBooking?->status }} --}}

                            @if($room->roomBooking->first()?->status == App\Models\RoomBooking::BOOKING_STATUS['booked'])
                            
                                <div class="col-md-2 col-sm-4">
                                    <div class="room-wrapper">
                                        <div class="room-status blue}}">{{ $room->roomBooking->first()?->status }}</div>
                                        <div class="room-img"><img src="{{ asset('img/booked-room.png') }}"></div>
                                        <div class="room-no">{{ $room->room_title }}</div>
                                        {{-- <div class="availibility margin-top">Next Available on: <span>{{ date('Y-m-d', strtotime('+1 day', strtotime($room->roomBooking->first()?->checkout_date))) }}</span></div> --}}
                                        <div class="">Booked by:<a target="_blank" href="{{ route('admin.members.show', $room->roomBooking->first()?->member?->id) }}">{{ $room->roomBooking->first()?->member?->name }}</a></div>
                                    </div>
                                </div>
                            @else    
                                <div class="col-md-2 col-sm-4">
                                    <div class="room-wrapper">
                                        <div class="room-status green">Available</div>
                                        <div class="room-img"><img src="{{ asset('img/vacant-room.png') }}"></div>
                                        <div class="room-no">{{ $room->room_title }}</div>
                                        <div><span>{{ $room->is_reserved ? 'Reserved Room':'' }}</span></div>
                                        {{-- <div class="availibility margin-top">Next Booking:</div> --}}
                                    </div>
                                </div>
                               
                            @endif
                        @endforeach
                        {{-- <div class="col-md-12"> 
                            <button type="button" class="btn btn-success">Confirm</button> 
                        </div> --}}
                    </div>
                </div>
                
    </div>
</div>



@endsection