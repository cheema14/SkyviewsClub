<?php

namespace App\Http\Controllers\Traits;

use App\Models\Room;
use App\Models\RoomBooking;
use DateInterval;
use DatePeriod;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

trait CheckRoomStatusTrait
{
    public function checkRoomStatus(RoomBooking $roomBooking)
    {
        $allDates = [];
        
        $startDate = new DateTime($roomBooking->checkin_date);
        $endDate = new DateTime($roomBooking->checkout_date);

        if($startDate == $endDate){
            $allDates[0] = $startDate;
            $allDates[1] = $startDate;
        }
        else{
            
            // DatePeriod::INCLUDE_END_DATE constant does not work
            // in php8.1 which is running on server.
            // so this is an alternate approach to include the 
            // checkout_date. 
            // if the checkin_date is 01-01-1991 and checkout_date is 03-01-1991
            // then allDates would be 01-01-XXXX,02-01-XXXX,03-01-XXXX
            
            // $endDate->modify('+1 day'); 
            $period = new DatePeriod(
                new DateTime($roomBooking->checkin_date),
                new DateInterval('P1D'), // P1D - Period 1 Day
                $endDate->modify('+1 day')
                // $endDate,
                // DatePeriod::INCLUDE_END_DATE
            );
    
            foreach ($period as $key => $value) {
                $allDates[] = $value->format('Y-m-d');       
            }
            
        }
        
        

        // $currentDate = clone $startDate; // clone the object $startDate
        // while ($currentDate <= $endDate) {
        //     $allDates[] = $currentDate->format('Y-m-d'); // Format the date as 'Y-m-d' and add it to the array
        //     $currentDate->modify('+1 day'); // Move to the next day
        // }

        
        $check_free_room_in_all_dates = RoomBooking::where('status', RoomBooking::BOOKING_STATUS['booked'])->where(function ($query) use ($roomBooking) {
                $query->where(function ($query) use ($roomBooking) {
                    $query->whereBetween('checkin_date', [$roomBooking->checkin_date, $roomBooking->checkout_date])
                        ->orWhereBetween('checkout_date', [$roomBooking->checkin_date, $roomBooking->checkout_date]);
                })
                    ->orWhere(function ($query) use ($roomBooking) {
                        $query->where('checkin_date', '<=', $roomBooking->checkin_date)
                            ->where('checkout_date', '>=', $roomBooking->checkout_date);
                    });
            })->get();

        

        $no_of_days_for_booking = count($allDates);
        $available_room_list = array();
        foreach($allDates as $value){
            $checkinDate = $value;
            $checkoutDate = $value;
            
            
            // Subtract rooms as per category_id
            if($roomBooking->manual_booking == 1){
                $rooms = Room::where('id','=',$roomBooking->room_id)->pluck('id');
                
            }
            else{
                $rooms = Room::where('category_id',$roomBooking->room_category_id)->pluck('id');
            }
            
            $roomsForDateRange = Room::whereNotIn('id', function ($query) use ($checkinDate, $checkoutDate,$roomBooking) {
                
                $query->select('room_id')
                    ->from('room_bookings')
                    ->where('status',RoomBooking::BOOKING_STATUS['booked'])
                    ->whereDate('checkin_date', '<=', $checkoutDate)
                    ->whereDate('checkout_date', '>=', $checkinDate);
            })->whereIn('id', $rooms)->pluck('id');
            
            
            

            
            $available_room_list = [
                'checkin_date' => $checkinDate,
                'checkout_date' => $checkoutDate,
                'rooms' => $roomsForDateRange,
            ];
        }
        //  dd($available_room_list);
        //  dd("ere");
        // for ($i = 0; $i<$no_of_days_for_booking; $i++) {
        //     // $checkinDate = $allDates[$i];
        //     // $checkoutDate = $allDates[$i+1];
        
        //     // $roomsForDateRange = Room::whereNotIn('id', function ($query) use ($checkinDate, $checkoutDate) {
        //     //     $query->select('room_id')
        //     //         ->from('room_bookings')
        //     //         ->where('status',RoomBooking::BOOKING_STATUS['booked'])
        //     //         ->whereDate('checkin_date', '<=', $checkoutDate)
        //     //         ->whereDate('checkout_date', '>=', $checkinDate);
        //     // })->pluck('id');
        
        //     // $available_room_list = [
        //     //     'checkin_date' => $checkinDate,
        //     //     'checkout_date' => $checkoutDate,
        //     //     'rooms' => $roomsForDateRange,
        //     // ];
        // }

        // dd($available_room_list,$available_room_list['rooms']);

        // $checkRoom = Roombooking::where('booking_room_category_id', $roomBooking->booking_room_category_id)
        //     ->where('room_category_id', $roomBooking->room_category_id)
        //     ->where('room_id', $roomBooking->room_id)
        //     ->where('room_type', $roomBooking->room_type)
        //     ->where('status', RoomBooking::BOOKING_STATUS['booked'])
        //     ->where(function ($query) use ($roomBooking) {
        //         $query->where(function ($query) use ($roomBooking) {
        //             $query->whereBetween('checkin_date', [$roomBooking->checkin_date, $roomBooking->checkout_date])
        //                 ->orWhereBetween('checkout_date', [$roomBooking->checkin_date, $roomBooking->checkout_date]);
        //         })
        //             ->orWhere(function ($query) use ($roomBooking) {
        //                 $query->where('checkin_date', '<=', $roomBooking->checkin_date)
        //                     ->where('checkout_date', '>=', $roomBooking->checkout_date);
        //             });
        //     })

        //     ->get()->first();

        return $available_room_list['rooms'];
    }

    public function find_other_bookings(RoomBooking $roomBooking){
        
        $other_bookings = RoomBooking::where('checkin_date','=',$roomBooking->checkin_date)
                    ->where('checkout_date','=',$roomBooking->checkout_date)
                    ->where('booking_room_category_id','=',$roomBooking->booking_room_category_id)
                    ->where('room_category_id','=',$roomBooking->room_category_id)
                    ->where('room_id','=',$roomBooking->room_id)
                    ->where('status','=','Pending')
                    ->get();

        foreach($other_bookings as $booking){
            $booking->status = 'Rejected';
            $booking->save();
        }

    }

    public function checkRoomStatusManually(Request $request){
        // dd($request->all(),$request->checkin);

        $allDates = [];
        
        $startDate = new DateTime($request->checkin);
        $endDate = new DateTime($request->checkout);
        
        if($startDate == $endDate){
            $allDates[0] = $startDate;
            $allDates[1] = $startDate;
        }
        else{
            
            // DatePeriod::INCLUDE_END_DATE constant does not work
            // in php8.1 which is running on server.
            // so this is an alternate approach to include the 
            // checkout_date. 
            // if the checkin_date is 01-01-1991 and checkout_date is 03-01-1991
            // then allDates would be 01-01-XXXX,02-01-XXXX,03-01-XXXX
            
            // $endDate->modify('+1 day'); 
            $period = new DatePeriod(
                new DateTime($request->checkin_date),
                new DateInterval('P1D'), // P1D - Period 1 Day
                $endDate->modify('+1 day')
                // DatePeriod::INCLUDE_END_DATE
            );
    
            foreach ($period as $key => $value) {
                $allDates[] = $value->format('Y-m-d');       
            }
            
        }


        $check_free_room_in_all_dates = RoomBooking::where('status', RoomBooking::BOOKING_STATUS['booked'])->where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->whereBetween('checkin_date', [$request->checkin, $request->checkout])
                    ->orWhereBetween('checkout_date', [$request->checkin, $request->checkout]);
            })
                ->orWhere(function ($query) use ($request) {
                    $query->where('checkin_date', '<=', $request->checkin)
                        ->where('checkout_date', '>=', $request->checkout);
                });
        })->get();

        $no_of_days_for_booking = count($allDates);
        $available_room_list = array();
        
        foreach($allDates as $value){
            $checkinDate = $value;
            $checkoutDate = $value;
            // dd($checkinDate,$checkoutDate);
            
            
            // Subtract rooms as per category_id
            // $rooms = Room::where('category_id',$request->room_category_id)->pluck('id');
            $rooms = Room::all()->pluck('id');
            
            $roomsForDateRange = Room::whereNotIn('id', function ($query) use ($checkinDate, $checkoutDate,$request) {
                
                $query->select('room_id')
                    ->from('room_bookings')
                    ->where('status',RoomBooking::BOOKING_STATUS['booked'])
                    ->whereDate('checkin_date', '<=', $checkoutDate)
                    ->whereDate('checkout_date', '>=', $checkinDate);
            })->whereIn('id', $rooms)->pluck('id');
            
            // dd($roomsForDateRange);
            
            $available_room_list = [
                'checkin_date' => $checkinDate,
                'checkout_date' => $checkoutDate,
                'rooms' => $roomsForDateRange,
            ];
        }

        return $available_room_list['rooms'];
    }
}
