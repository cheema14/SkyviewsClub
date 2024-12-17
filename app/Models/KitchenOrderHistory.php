<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class KitchenOrderHistory extends Model
{
    use HasFactory, BelongsToTenant;

    public $table = 'kitchen_order_history';

    protected $fillable = [
        'order_id',
        'items_data',
    ];
}
