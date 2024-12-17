<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ApiResponser;
use App\Http\Controllers\Traits\MemberHasBooking;
use App\Models\Member;
use App\Models\Menu;
use App\Models\MenuItemCategory;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\TableTop;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberApiController extends Controller
{
    use ApiResponser,MemberHasBooking;

    protected $message = '';

    protected $data = [];

    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'membership_no' => 'required|string|exists:members,membership_no,deleted_at,NULL',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }
        
        if (! Auth::guard('member')->attempt($validator->validated())) {
            return $this->error('Credentials not matched', 401);
        }

        return $this->success(
            [
                'token' => Auth::guard('member')
                    ->user()
                    ->createToken('member-token', ['list-menus', 'change-password', 'update-profile'])
                    ->plainTextToken,
                'member' => Auth::guard('member')->user(),
            ],
            'Login successful'
        );

    }

    public function logout()
    {

        Auth::guard('member')
            ->user()
            ->tokens()
            ->delete();

        return [
            'message' => 'Logged out successfully',
        ];
    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'membership_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::query()->with('dependents')
            ->where('membership_no', $request->membership_no)
            ->first();

        if (! $member) {
            return $this->error(__('apis.member.failedSearch'), 200);
        }

        $tableTop = TableTop::all();

        return $this->success(
            ['member' => $member, 'tableTop' => $tableTop], __('apis.member.search')
        );
    }

    public function menus()
    {

        return $this->success([
            'menu' => Menu::with('menuItems')->get(),
            'menuItemCategories' => MenuItemCategory::all(),
        ],
            __('apis.member.menus')
        );
    }

    public function change_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cnic_no' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::query()
            ->where('cnic_no', $request->cnic_no)
            ->first();

        if (! $member) {
            return $this->error('Member not found', 403, $validator->errors());
        }

        $member->password = bcrypt($request->password);
        $member->save();

        return $this->success(['member' => $member], __('apis.member.changePassword'));

    }

    public function update_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'photo' => 'image|mimes:jpeg,png,jpg',
            'cell_no' => 'string|max:11',
            'permanent_address' => 'string|max:150',
            'cnic_no' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return $this->error('', 401, $validator->errors());
        }

        $member = Member::query()
            ->where('cnic_no', $request->cnic_no)
            ->first();

        $file = $request->file('photo');

        if ($request->hasFile('photo')) {
            $member->media()->delete();
            $member->addMedia($file)->toMediaCollection('photo');
        }

        return $this->success(['member' => $member], __('apis.member.updateProfile'));
    }

    public function room_booking(Request $request)
    {
        $guest_name = $guest_cnic = null;
        $bookingVal = false;
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            // 'booking_room_category_id' => 'required',
            'room_category_id' => 'required',
            // 'room_id' => 'required',
            'room_bookings_member_id' => 'required|exists:members,id',
            'checkin_date' => [
                'required',
                'after_or_equal:today',
            ],
            'checkout_date' => [
                'required',
                'after:checkin_date',
            ],
            'price_at_booking_time' => 'required|numeric',
            'booking_has_guests' => 'required|in:0,1',
            'guest_mobile_no' => 'required_if:booking_has_guests,1|numeric|min:11|nullable',
            'guest_name' => [
                'required_if:booking_has_guests,1',
                'nullable',
                function ($attribute, $value, $fail) use ($request) {

                    if ($request->input('booking_has_guests') == 0) {
                        return true;
                    }

                    if (! is_string($value)) {
                        $fail($attribute.' must be a string.');
                    }
                },
            ],
            'guest_cnic' => [
                'required_if:booking_has_guests,1',
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    // Additional check to make sure the validation is ignored when booking_has_guests is 0
                    if ($request->input('booking_has_guests') == 0) {
                        return true;
                    }

                    if (! is_numeric($value) || strlen((string) $value) !== 13) {
                        $fail($attribute.' must be numeric and have 13 digits.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return $this->error('', 200, $validator->errors());
        }

        // Parse the check-in and check-out dates using Carbon
        $checkinDate = Carbon::parse($request->checkin_date);
        $checkoutDate = Carbon::parse($request->checkout_date);


        /*
            As always the mobile developer puts everything on
            the shoulder of the Web developer. 
            Instead checking on the frontend that a date range cannot
            have red flagged dates. 
            The below piece of code identifies if a date range i-e
            $request->checkin_date and $request->checkout_date
            has red flagged day(s) in it. If so then return false and error
            response.
        */ 
        $response = $this->get_booked_dates($request);
        $booked_dates = json_decode($response->getContent());
        
        $red_flagged_date_check = $this->validate_booking_date_range($request->checkin_date,$request->checkout_date,$booked_dates);
        // dd($red_flagged_date_check);
        if(! $red_flagged_date_check){
            return $this->error(Lang::get('apis.roomBooking.dateRangeBooked'), 200, '');
        }
        

        // Calculate the number of days between the two dates
        $no_of_days = $checkoutDate->diffInDays($checkinDate) ;
        $no_of_days = max($no_of_days, 1);
        // dd($no_of_days);
        // $room_status = ChangeRoomStatus::dispatch($request->all());

        $booking_category_id = $request->booking_room_category_id;
        $room_category_id = $request->room_category_id;
        $room_id = $request->room_id;
        
        $checkRoom = Roombooking::where('booking_room_category_id', $booking_category_id)
            ->where('room_category_id', $room_category_id)
            ->where('room_id', $room_id)
            ->where('room_type', $request->room_type)
            ->where('status', RoomBooking::BOOKING_STATUS['booked'])
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

        // $member_has_booked_already = $this->member_has_already_booked($request);
        
        // if($member_has_booked_already){
        //     return $this->error(Lang::get('apis.roomBooking.memberAlreadyBooked'), 200, '');
        // }

        if ($checkRoom) {
            return $this->error(Lang::get('apis.roomBooking.roomOccupied'), 200, '');
        }

        if ($request->booking_has_guests) {
            $guest_name = $request->guest_name;
            $guest_cnic = $request->guest_cnic;
            $bookingVal = true;
        }
        // disounct is posted from web end
        $roomBooking = RoomBooking::create(
            [
                'booking_room_category_id' => $request->booking_room_category_id,
                'room_category_id' => $request->room_category_id,
                'room_id' => $request->room_id,
                'room_bookings_member_id' => $request->room_bookings_member_id,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'price_at_booking_time' => $request->price_at_booking_time,
                'no_of_days' => $no_of_days,
                'total_price' => $request->discount ? ($request->price_at_booking_time * $no_of_days) - $request->discount : $request->price_at_booking_time * $no_of_days,
                'room_type' => $request->room_type,
                'status' => RoomBooking::BOOKING_STATUS['pending'],
                'booking_has_guests' => $bookingVal,
                'guest_name' => $request->booking_has_guests == 1 ? $request->guest_name : null,
                'guest_cnic' => $request->booking_has_guests == 1 ? $request->guest_cnic : null,
                'guest_mobile_no' => $request->booking_has_guests == 1 ? $request->guest_mobile_no : null,
                'is_paid' => 0,
            ]
        );
        $roomBooking['checkin_time'] = config('constants.CHECKIN_TIME');
        $roomBooking['checkout_time'] = config('constants.CHECKOUT_TIME');


        return $this->success(
            ['roomBooking' => $roomBooking], __('apis.roomBooking.save')
        );

    }

    public function room_list(Request $request)
    {

        return $this->success(
            [
                'room_categories_mapping' => RoomCategoryCharge::get(),
            ],
            __('apis.member.roomList'),
        );
    }

    public function get_booked_dates(Request $request)
    {
        
        $currentMonth = Carbon::now()->format('m');
        
        // $all_booked = RoomBooking::select('checkin_date', 'checkout_date')
        //     ->whereMonth('checkin_date', $currentMonth)
        //     ->groupBy('checkin_date')
        //     ->havingRaw('COUNT(DISTINCT room_id) = ?', [Room::count()])
        //     ->get();
        $all_booked = RoomBooking::select('checkin_date', \DB::raw('MIN(checkout_date) as checkout_date'))
    ->whereMonth('checkin_date', $currentMonth)
    ->groupBy('checkin_date')
    ->havingRaw('COUNT(DISTINCT room_id) = ?', [Room::count()])
    ->get();
        $booked_dates = [];

        foreach ($all_booked as $booking) {
            $checkin_date = Carbon::parse($booking->checkin_date);
            $checkout_date = Carbon::parse($booking->checkout_date);

            $current_date = $checkin_date;
            while ($current_date <= $checkout_date) {
                $booked_dates[] = $current_date->format('Y-m-d');
                $current_date->addDay(); // Move to the next day
            }
        }
        
        return $this->success(
            [
                'booked_dates' => $booked_dates,
            ],
            __('apis.member.bookedDates'),
        );
    }

    public function get_available_dates(Request $request)
    {
        // dd($request->all());

        // $current_month_start = Carbon::now()->startOfMonth()->addDays(14); // Today (15th of the current month)

        // if (! empty($request->till_date_month) && is_numeric($request->till_date_month) && $request->till_date_month >= 1 && $request->till_date_month <= 12) {
        //     // Use the provided month as the end date
        //     $next_month_end = Carbon::now()->addMonths(1)->startOfMonth()->month($request->till_date_month)->endOfMonth();
        // } else {
        //     // Use the last day of the next month as the end date if $request->til_date_month is empty or invalid
        //     $next_month_end = Carbon::now()->addMonths(1)->endOfMonth(); // Last day of the next month
        // }

        // Get all the dates between today and the last day of next month
        // $available_dates = [];
        // $current_date = $current_month_start->copy();

        // // lte Carbon helper method Less than equal
        // while ($current_date->lte($next_month_end)) {
        //     $available_dates[] = $current_date->toDateString();
        //     $current_date->addDay();
        // }

        $existing_dates = RoomBooking::pluck('checkin_date')->merge(RoomBooking::pluck('checkout_date'))->unique()->toArray();
        // $available_dates = array_diff($available_dates, $existing_dates);

        $existing_dates_with_total_price = RoomBooking::whereIn('checkin_date', $existing_dates)
            ->orWhereIn('checkout_date', $existing_dates)
            ->pluck('total_price', 'checkin_date')
            ->merge(RoomBooking::whereIn('checkin_date', $existing_dates)
                ->orWhereIn('checkout_date', $existing_dates)
                ->pluck('total_price', 'checkout_date'))
            ->toArray();
        // dd($existing_dates_with_total_price);

        return $this->success(
            [
                'booked_dates' => $existing_dates_with_total_price,
            ],
            __('apis.member.bookedDates'),
        );

    }
}
