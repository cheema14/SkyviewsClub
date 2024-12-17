@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>

    .guest_div{
        display:none;
    }

    .submit_search{
        display:none;
    }
    /* Loading styles when Download button is clicked */
    .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("/examples/images/loader.gif") center no-repeat;
    }

    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
</style>
@endsection
@include('partials.'.tenant()->id.'.flash_messages')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.roomBooking.title_singular') }}
        
    </div>

    
    <div class="card-body">
        <h5>Manually Book Room </h5>
        <form style="margin-top:50px;" method="POST" action="{{ route('admin.roomBooking.storeManualRoomBooking') }}">
        @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="checkin_date">Checkin Date:</label>
                    <input type="text" name="checkin_date" class="form-control manual_checkin_date" value="{{ request('checkin_date') }}">
                </div>
                
                <div class="form-group col-md-6">
                    <label for="checkout_date">Checkout Date:</label>
                    <input type="text" name="checkout_date" class="form-control manual_checkout_date" value="{{ request('checkout_date') }}">
                </div>

                <div class="form-group col-md-4">
                    <label class="" for="room">{{ trans(tenant()->id.'/cruds.roomBooking.fields.members_list') }}</label>
                    <select class="form-control select2 {{ $errors->has('room_bookings_member_id') ? 'is-invalid' : '' }}" name="room_bookings_member_id" id="room_bookings_member_id" required>
                        <option value="" disabled selected>Select Member</option>
                        @foreach($members_list as $id => $member)            
                            <option value="{{ $member->id }}" {{ old('room_bookings_member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }} - {{ $member->membership_no }} - {{ $member->old_membership_no }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="discount">Discount:</label>
                    <input type="text" name="discount" class="form-control" value="">
                </div>

                <div class="col-md-2">
                    <p>Member Rate:<p style="color:red;" class="member_rate"></p></p>
                    <p>Guest Rate:<p style="color:red;" class="guest_rate"></p></p>
                </div>
                
                <div class="form-group col-md-6">
                    <label class="" for="room">{{ trans(tenant()->id.'/cruds.roomBooking.fields.room') }}</label>
                    <select class="form-control {{ $errors->has('room_id') ? 'is-invalid' : '' }}" name="room_id" id="room_id" required>
                        <option value="" disabled selected>Select Room</option>
                    </select>    
                </div>

                <input type="hidden" id="room_category_id" name="room_category_id" value="2">
                <input type="hidden" id="booking_has_guests" name="booking_has_guests" value="0">
                
                <div class="form-group col-sm-2">
                    <label class="" for="room">{{ trans(tenant()->id.'/cruds.roomBooking.fields.booking_has_guests') }}</label>
                    <input class="form-control" type="checkbox" id="guest_checkbox" name="guest_checkbox" value="0">
                </div>

                <div class="form-group col-md-6 guest_div">
                    <label class="required" for="guest_name">{{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_name') }}</label>
                    <input class="form-control {{ $errors->has('guest_name') ? 'is-invalid' : '' }}" type="text" name="guest_name" id="guest_name" value="{{ old('guest_name', '') }}">
                    @if($errors->has('guest_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('guest_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_name_helper') }}</span>
                </div>

                <div x-data class="form-group col-md-6 guest_div">
                    <label class="required" for="guest_mobile_no">{{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_mobile_no') }}</label>
                    <input x-mask="99999999999" placeholder="XXXXXXXXXXX" class="form-control {{ $errors->has('guest_mobile_no') ? 'is-invalid' : '' }}" type="text" name="guest_mobile_no" id="guest_mobile_no" value="{{ old('guest_mobile_no', '') }}">
                    @if($errors->has('guest_mobile_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('guest_mobile_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_mobile_no_helper') }}</span>
                </div>
                
                <div x-data class="form-group col-md-4 guest_div">
                    <label class="required" for="guest_cnic">{{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_cnic') }}</label>
                    <input x-mask="9999999999999" placeholder="XXXXXXXXXXXXX" class="form-control {{ $errors->has('guest_cnic') ? 'is-invalid' : '' }}" type="text" name="guest_cnic" id="guest_cnic" value="{{ old('guest_cnic', '') }}">
                    @if($errors->has('guest_cnic'))
                        <div class="invalid-feedback">
                            {{ $errors->first('guest_cnic') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_cnic_helper') }}</span>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="button" id="searchRooms" class="btn btn-primary">Search Rooms</button>
                </div>
                <div class="col-md-4">
                    <button type="submit" id="submit_search" class="btn btn-primary submit_search">Submit</button>
                </div>
            </div>
        </form>
    </div>
    
        

</div>
<div class="overlay"></div>
@endsection
@section('scripts')
<script>
    $(document).on("change","#guest_checkbox",function(){
        
        var checkVal = $(this).is(':checked') ? 1 : 0;
        $("#booking_has_guests").val(checkVal);
        
        if(checkVal){
            $(".guest_div").show();
        }
        else{
            $(".guest_div").hide();
        }

    });
    $(".manual_checkin_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        minDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".manual_checkout_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
        useCurrent: false,
    });

    // Prevent checkout date from being before the selected check-in date
    $(".manual_checkin_date").on("dp.change", function (e) {
        $(".manual_checkout_date").data("DateTimePicker").minDate(e.date);
    });

    // Prevent check-in date from being after the selected check-out date
    $(".manual_checkout_date").on("dp.change", function (e) {
        $(".manual_checkin_date").data("DateTimePicker").maxDate(e.date);
    });

</script>


<script>
    $(document).on("click","#searchRooms",function(){

        
        // add loader
        $("body").addClass("loading");

        let checkin_date = $(".manual_checkin_date").val();
        let checkout_date = $(".manual_checkout_date").val();
        let room_category_id = $("#room_category_id").val();

        if(checkin_date == ''){
            alert("Select checkin date before searching rooms");
            $("body").removeClass("loading");
            return false;
        }

        if(checkout_date == ''){
            alert("Select checkout date before searching rooms");
            $("body").removeClass("loading");
            return false;
        }

                $.ajax({
                    url: "{{ route('admin.roomBooking.searchRoomManually') }}", // Your export route here
                    method: 'GET',
                    dataType: 'json',
                    data:{checkin:checkin_date,checkout:checkout_date,room_category_id:room_category_id},
                    success: function (data) {
                        
                        var $dropdown = $('#room_id');
                        $dropdown.empty(); // Clear any previous options
                        $dropdown.append('<option value="">Select Room</option>'); // Add default option

                        // Loop through the received data and populate the dropdown
                        $.each(data, function (key, room) {
                            // Append each room as an option
                            $dropdown.append(
                                $('<option></option>')
                                    .attr('value', room.id)
                                    .attr('data-memberprice', room.member_self)
                                    .attr('data-guestprice', room.member_guest)
                                    .text(room.room_title + ' - ' + room.block + ' - ' + room.floor)
                            );
                        });
                        $("body").removeClass("loading");
                    },
                    error: function (error) {
                        $("body").removeClass("loading");
                        alert("Error fetching rooms list. Please try again!");
                    }
                });
    });

    $(document).on("change","#room_id",function(){
        
        $(".member_rate").text();
        $(".guest_rate").text();
        $(".submit_search").show();
        
        $(".member_rate").text($(this).find(':selected').data('memberprice'));
        $(".guest_rate").text($(this).find(':selected').data('guestprice'));
    });

    $(document).on("click",'.submit_search',function(event){

        if($("#room_bookings_member_id").val() == null){
            alert("Select Member");
            event.preventDefault();
        }

        if($("#room_id").val() == ''){
            alert("Select Room");
            event.preventDefault();
        }

        if($("#guest_checkbox").is(':checked')){
            
            if($("#guest_name").val() == '' || $("#guest_mobile_no").val() == '' || $("#guest_cnic").val() == ''){
                alert("Fill out all guest details before submitting booking request.");
                event.preventDefault();
            }
        }
    })
</script>
@parent

@endsection