<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $table = 'rooms';

    public function roomBooking()
    {
        return $this->hasMany(RoomBooking::class,'room_id');
    }

    public function roomCategory(){
        return $this->hasOne(RoomCategory::class,'id','category_id');
    }
}
