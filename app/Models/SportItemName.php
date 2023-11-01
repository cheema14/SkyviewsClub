<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SportItemName extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'sport_item_names';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'item_name',
        'item_class_id',
        'item_rate',
        'unit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function item_class()
    {
        return $this->belongsTo(SportItemClass::class, 'item_class_id');
    }
}
