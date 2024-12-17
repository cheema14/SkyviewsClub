<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class SportItemClass extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'sport_item_classes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'item_class',
        'item_type_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function item_type()
    {
        return $this->belongsTo(SportItemType::class, 'item_type_id');
    }

    public function sportItems()
    {
        return $this->hasMany(SportItemName::class, 'item_class_id');
    }
}
