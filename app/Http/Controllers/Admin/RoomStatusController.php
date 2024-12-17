<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingCategory;
use App\Models\Room;
use App\Models\RoomCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomStatusController extends Controller
{
    public function index(Request $request){

        $bookingCategories = RoomCategory::all();
        
        // Request Params
        $checkin_date = Carbon::now()->format('Y-m-d');
        $checkout_date = Carbon::parse($checkin_date)->endOfMonth()->format('Y-m-d');
        $room_category = '';
        $bookedRooms = array();


        $all_rooms = Room::query();

        // If checkin date is provided, filter by it
        if ($request->has('checkin_date')) {
            $checkin_date = Carbon::parse($request->checkin_date)->format('Y-m-d');
            $all_rooms->with(['roomBooking' => function ($query) use ($checkin_date) {
                $query->where('checkin_date', '<=', $checkin_date)
                    ->where('checkout_date', '>=', $checkin_date);
            }]);
        }

        // If checkout date is provided, filter by it
        if ($request->has('checkout_date')) {
            $checkout_date = Carbon::parse($request->checkout_date)->format('Y-m-d');
            $all_rooms->with(['roomBooking' => function ($query) use ($checkout_date) {
                $query->where('checkin_date', '<=', $checkout_date)
                    ->where('checkout_date', '>=', $checkout_date);
            }]);
        }

        // If room category is provided, filter by it
        if ($request->has('room_category')) {
            $room_category = $request->room_category;
            $all_rooms->where('category', $room_category);
        }

        // If no dates are provided, filter by current month
        if (!$request->has('checkin_date') && !$request->has('checkout_date')) {
            $currentMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $nextMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            $all_rooms->with(['roomBooking' => function ($query) use ($currentMonth, $nextMonth) {
                $query->where('checkin_date', '<=', $nextMonth)
                    ->where('checkout_date', '>=', $currentMonth);
            }]);
        }

        $all_rooms_data = $all_rooms->get();
        // dd($all_rooms_data);


        

        




        // $rooms = Room::select('rooms.*', 'room_bookings.*')
        // ->leftJoin('room_bookings', function($join) use ($request) {
        //     $join->on('room_bookings.room_id', '=', 'rooms.id')
        //         ->where('room_bookings.checkin_date', '<=', $request->checkin_date)
        //         ->where('room_bookings.checkout_date', '=', $request->checkout_date);
        // })
        // ->where('rooms.category_id', '=', $request->category_id)
        // ->with(['roomBooking', 'roomBooking.member'])
        // ->get();

        // dd($rooms);
        
        // $rooms = Room::with(['roomBooking' => function ($query) use ($request) {
        //     $query->where(function ($query) use ($request) {
        //         $query->where('checkin_date', '<=', $request->checkin_date)
        //               ->where('checkout_date', '>=', $request->checkin_date);
        //     })->where(function ($query) use ($request) {
        //         $query->where('checkin_date', '<=', $request->checkout_date)
        //               ->where('checkout_date', '>=', $request->checkout_date);
        //     });
        // }])
        // ->with(['roomBooking.member']);
        // ->get();
        
        

        // if(isset($request->room_category)){
        //     $rooms->where('category_id', '=', $request->room_category);
        // }

       $all_rooms = $all_rooms_data;
    // dd($all_rooms);
        
        return view('admin.roomBooking.rooms_availability',
            compact('bookingCategories','all_rooms')
        );
    }
}
