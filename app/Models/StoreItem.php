<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreItem extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'store_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'store_id',
        'item_id',
        'unit_id',
        'item_class_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function item()
    {
        return $this->belongsTo(ItemType::class, 'item_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function item_class()
    {
        return $this->belongsTo(ItemClass::class, 'item_class_id');
    }
}
