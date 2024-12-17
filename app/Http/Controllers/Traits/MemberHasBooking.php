<?php

namespace App\Http\Controllers\Traits;

use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait MemberHasBooking
{
    public function member_has_already_booked(Request $request){
        
        $checkRoom = Roombooking::where('booking_room_category_id', $request->booking_room_category_id)
            ->where('room_category_id', $request->room_category_id)
            ->where('room_id', $request->room_id)
            ->where('room_type', $request->room_type)
            ->where('room_bookings_member_id', $request->room_bookings_member_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereBetween('checkin_date', [$request['checkin_date'], $request['checkout_date']])
                        ->orWhereBetween('checkout_date', [$request['checkin_date'], $request['checkout_date']]);
                })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('checkin_date', '<=', $request['checkin_date'])
                            ->where('checkout_date', '>=', $request['checkout_date']);
                    });
            })

            ->get()->first();
            
            return $checkRoom;
    }    

    public function validate_booking_date_range($checkin_date,$checkout_date,$booked_dates){
        // dd($checkin_date,$checkout_date,$booked_dates->data->booked_dates);
        $booked_dates = $booked_dates->data->booked_dates;
        $checkin_date = Carbon::parse($checkin_date);
        $checkout_date = Carbon::parse($checkout_date);
        $red_flag = true;

        $current_date = $checkin_date;
        while ($current_date <= $checkout_date) {
            if (in_array($current_date->format('Y-m-d'), $booked_dates)) {
                $red_flag = false;
            }
            $current_date->addDay(); // Move to the next day
        }

        return $red_flag;
    }
}
