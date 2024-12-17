<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategoryCharge extends Model
{
    use HasFactory;

    public $table = 'room_category_charges';

    protected $fillable = [
        'room_category_id',
        'room_id',
        'single_person_charges',
        'double_person_charges',
        'member_self',
        'member_guest',
    ];

    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }

    public static function updateStatusToFree()
    {
        self::query()->update(['status' => 'Free']);
    }
}
