<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class TableTop extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'table_tops';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'   => 'Active',
        'reserved' => 'Reserved',
        'free'     => 'Free',
    ];

    protected $fillable = [
        'code',
        'capacity',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function orders(){
        return $this->hasMany(Order::class,'id');
    }
}
