<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\V1\MemberApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CheckRoomStatusTrait;
use App\Models\BookingCategory;
use App\Models\Member;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\Transaction;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomBookingController extends Controller
{
    use CheckRoomStatusTrait;

    public function free_all_rooms()
    {
        RoomBooking::updateStatusToFree();
        // $results =

        // if (! $results) {
        //     echo 'Set to free';
        // } else {
        //     echo 'something went wrong';
        // }
        return back();

    }

    public function show_booking_details(RoomBooking $roomBooking)
    {
        abort_if(Gate::denies('room_booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roomBooking = $roomBooking->load('member', 'bookingCategory', 'roomCategory');
        
        return view('admin.roomBooking.show', compact('roomBooking'));
    }

    public function list_all_bookings(Request $request)
    {
        abort_if(Gate::denies('room_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // dd($request->all());

        $bookingCategories = BookingCategory::all();

        $currentDate = Carbon::now();
        $startDate = $currentDate->startOfMonth();
        $endDate = $currentDate->endOfMonth();

        $currentMonth = Carbon::now()->month + 1;

        // $roomBookings = RoomBooking::with('member', 'bookingCategory', 'roomCategory')
        //     ->whereMonth('checkin_date', '=', $currentMonth)
        //     ->orWhereMonth('checkout_date', '=', $currentMonth)
        //     ->get();
        // dd($request->all());

        $query = RoomBooking::with(['bookingCategory', 'roomCategory', 'member','roomBookingTransactions'])->orderBy('id', 'desc');

        // if (isset($request->checkin_date)) {
        //     $query->where('checkin_date', '>=', $request->input('checkin_date'));
        // }

        // if (isset($request->checkout_date)) {
        //     $query->where('checkout_date', '<=', $request->input('checkout_date'));
        // }
        $query->when($request->filled('checkin_date'), function ($query) use ($request) {
            $checkinDate = $request->input('checkin_date');
            $query->where('checkin_date', '>=', $checkinDate);
        });
        
        $query->when($request->filled('checkout_date'), function ($query) use ($request) {
            $checkoutDate = $request->input('checkout_date');
            $query->where('checkout_date', '<=', $checkoutDate);
        });

        if ($request->filled('checkin_date') && $request->filled('checkout_date')) {
            $checkinDate = $request->input('checkin_date');
            $checkoutDate = $request->input('checkout_date');
        
            $query->where(function ($query) use ($checkinDate, $checkoutDate) {
                $query->where('checkin_date', '<=', $checkoutDate)
                      ->where('checkout_date', '>=', $checkinDate);
            });
        }

        if (isset($request->booking_category)) {
            $query->where('booking_room_category_id', '=', $request->input('booking_category'));
        }

        if (isset($request->room_category)) {
            $query->where('room_category_id', '=', $request->input('room_category'));
        }

        if (isset($request->status)) {
            $query->where('status', '=', $request->input('status'));
        }

        $roomBookings = $query->get();
        
        return view('admin.roomBooking.index', compact('roomBookings', 'bookingCategories'));

    }

    public function destroy(RoomBooking $roomBooking)
    {
        abort_if(Gate::denies('room_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roomBooking->delete();

        return back();
    }

    public function approve_booking(RoomBooking $roomBooking, Request $request)
    {
        abort_if(Gate::denies('room_booking_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        
        $current_date = Carbon::now()->format('d-m-Y');

        $checkin_date = $roomBooking->checkin_date;
        
        if($current_date > $checkin_date){
           return back()->with('booking_expired', 'Room Booking has expired.'); 
        }
        
        // if manual booking - 
        // on call booking then the admin 
        // has selected a room as well. 
        // so He just needs to approve it to follow and complete
        // the process of room booking.
        
        $check_room_status = $this->checkRoomStatus($roomBooking, $request);
        
        $message = '';
        $color = '';
        
        // if request->status is not empty and $check_room_status is null which means 
        // there's no booking already
        // then go ahead and save the status as accepted otherwise do not change status

        $available_rooms = Room::whereIn('id', $check_room_status)->get();
        
        $roomBooking->load('member');
        
        $members_list = Member::where('membership_status','=',Member::MEMBERSHIP_STATUS_SELECT['Active'])->get();
        
        return view('admin.roomBooking.assign_room', 
                compact('available_rooms','roomBooking','members_list')
            );

        // if (! empty($request->status) && is_null($check_room_status)) {
        //     $roomBooking->status = $request->status;
        //     $roomBooking->save();
        //     $this->find_other_bookings($roomBooking);
            
        //     $message = 'Booking status changed successfully.';
        //     $color = 'created';
        // } else {
        //     $message = 'Booking already exists.';
        //     $color = 'fail';
        // }

        // return redirect()->route('admin.roomBooking.listAllBookings')->with($color, $message);

    }

    public function save_room_booking(RoomBooking $roomBooking,Request $request){
        
        $bookingData = json_decode($request->roomBooking,true);
        $room_selected = $request->room_id;
        
        // Fetch Room Info to get category id
        $room_info = Room::with('roomCategory')->where('id',$room_selected)->first();
        
        $roomBooking->status = RoomBooking::BOOKING_STATUS['booked'];
        $roomBooking->room_id = $room_selected;
        $roomBooking->room_category_id = $room_info->roomCategory?->id ?? null;
        
        if(request()->has('membership_no')){
            $roomBooking->room_bookings_member_id = request()->membership_no; 
        }
        
        $roomBooking->save();
        $message = 'Room booked successfully';
        $color = 'created';

        // Now create a transaction so that it can be reflected in the bill
        $roomBooking->roomBookingTransactions()->create([
            'code'=>'',
            'user_id'=>auth()->user()->id,
            'type'=>Transaction::TYPE_SELECT['Credit'],
            'status'=> Transaction::STATUS_SELECT['Success']
        ]);

        return redirect()->route('admin.roomBooking.listAllBookings')->with($color, $message);
    }

    public function reject_booking(RoomBooking $roomBooking, Request $request)
    {
        abort_if(Gate::denies('room_booking_approve'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (! empty($request->status)) {
            $roomBooking->status = $request->status;
            $roomBooking->save();
        }

        return redirect()->route('admin.roomBooking.listAllBookings')->with('updated', 'Booking request rejected.');
    }

    public function print_booking_details(RoomBooking $roomBooking){
        $roomBooking = $roomBooking->load('member');
        
        return view('admin.bills.booking_receipt', compact('roomBooking'));
    }

    public function print_booking_confirmation(RoomBooking $roomBooking){
        $roomBooking = $roomBooking->load('member');
        // dd($roomBooking);
        return view('admin.monthlyBills.receipts.booking_confirmation_receipt', compact('roomBooking'));
    }

    public function book_room_through_web(Request $request){
        
        $members_list = Member::where('membership_status','=',Member::MEMBERSHIP_STATUS_SELECT['Active'])->get();
        
        return view('admin.roomBooking.book_manual_room',compact('members_list'));
    }

    public function search_rooms_manually(Request $request){

        $check_room_status = $this->checkRoomStatusManually($request);
        $available_rooms = Room::whereIn('id', $check_room_status)->get();

        return json_encode($available_rooms);
    }

    public function store_manual_room_booking(Request $request){
        
        // dd($request->all());

        
        $request['checkin_date'] = $request->checkin_date;
        $request['checkout_date'] = $request->checkout_date;
        $request['booking_has_guests'] = $request->booking_has_guests;
        $request['room_bookings_member_id'] = $request->room_bookings_member_id;
        $request['room_category_id'] = Room::where('id','=',$request->room_id)->get()->pluck('category_id')->first();
        $request['manual_booking'] = 1;
        
        if($request->booking_has_guests){
            $request['guest_mobile_no'] = $request->guest_mobile_no;
            $request['guest_name'] = $request->guest_name;
            $request['guest_cnic'] = $request->guest_cnic;
        }
        
        $discount = $request->discount ? $request->discount : 0;
        if($request->booking_has_guests){
            $price_at_booking_time = Room::where('id',$request->room_id)->get()->pluck('member_guest')->first();
        }
        else{
            $price_at_booking_time = Room::where('id',$request->room_id)->get()->pluck('member_self')->first();
        }
        
        // $price_at_booking_time = $price_at_booking_time - $discount;

        $request['price_at_booking_time'] = $price_at_booking_time;
        $request['discount'] = $discount;
        
        $bookRoomManually = new MemberApiController();
        $response = $bookRoomManually->room_booking($request);
        $response = $response->getData(true);
        
        // before redirection
        // if there is any discount then keep its record and add to the roomBooking record
        // for saving the record
        $roomBookingId = $response['data']['roomBooking']['id'];
        $roomBooking = RoomBooking::where('id',$roomBookingId)->get()->first();

        if($request->discount){
            $roomBooking->discount = $request->discount;
        }
        
        $roomBooking->manual_booking = 1;
        $roomBooking->save();
        
        if($response['status'] == false){
            return redirect()->back()->with('missingParams', 'Some Parameters are missing in your request.'); ;
        }
        
        return redirect()->route('admin.roomBooking.listAllBookings')->with('roomBooked', 'Room booked successfully. Kindly approve it.'); ;
    }
}
