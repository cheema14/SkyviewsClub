<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiResponser;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberBookingApiController extends Controller
{
    use ApiResponser;

    protected $api_key = '';

    public function __construct(){
        
        // $this->api_key = request()->header('x-api-key');

        // if($this->api_key != config('constants.x-api-key')){
        //     $message = array("status" => FALSE,'message' => "Missing params. Please verify parameters",'code'=>200);
        //     print_r(json_encode($message,true));
        //     die;
        // }
    }

    public function get_my_bookings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::find($request->member_id);

        if (! $member) {
            return $this->error(__('apis.member.failedSearch'), 200);
        }

        $bookings = $member->bookings()->latest()->get()->map(function ($booking) {
            $booking['checkin_time'] = config('constants.CHECKIN_TIME');
            $booking['checkout_time'] = config('constants.CHECKOUT_TIME');
            return $booking;
        });
        
        return $this->success(
            [
                'bookings' => $bookings,
            ],
            __('apis.member.myBookings')
        );

    }
}
