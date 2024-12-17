<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCategory extends Model
{
    use HasFactory;

    public $table = 'booking_categories';

    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class, 'booking_room_category_id');
    }
}
