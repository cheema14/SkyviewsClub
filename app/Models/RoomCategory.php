<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use HasFactory;

    public $table = 'room_categories';

    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class, 'room_category_id');
    }
}
