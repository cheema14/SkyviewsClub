<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class SportItemType extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'sport_item_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'item_type',
        'division_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sportsDivision()
    {
        return $this->belongsTo(SportsDivision::class, 'division_id');
    }

    public function sportItemClasses()
    {
        return $this->hasMany(SportItemClass::class, 'item_type_id', 'id');
    }
}
