<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;

    public $table = 'room_bookings';

    const BOOKING_STATUS = [
        'booked' => 'Booked',
        'pending' => 'Pending',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'stalled' => 'Stalled',
    ];

    protected $fillable = [
        'booking_room_category_id',
        'room_category_id',
        'room_id',
        'room_bookings_member_id',
        'checkin_date',
        'checkout_date',
        'price_at_booking_time',
        'no_of_days',
        'total_price',
        'room_type',
        'status',
        'booking_has_guests',
        'guest_name',
        'guest_cnic',
        'guest_mobile_no',
        'is_paid',
        'manual_booking',
    ];

    public function roomCategoryCharge()
    {
        return $this->hasMany(RoomCategoryCharge::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'room_bookings_member_id', 'id');
    }

    public function bookingCategory()
    {
        return $this->belongsTo(BookingCategory::class, 'booking_room_category_id');
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public static function updateStatusToFree()
    {
        self::query()->update(['status' => 'Free']);
    }

    public function roomBookingTransactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id', 'id');
    }

    
}
