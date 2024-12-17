<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Transaction extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'Cash' => 'Cash',
        'Credit' => 'Credit',
        'Debit' => 'Debit',
        'Card' => 'Card',
    ];

    protected $fillable = [
        'user_id',
        'order_id',
        'code',
        'type',
        'status',
        'bill_amount',
        'amount_paid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'New' => 'New',
        'Pending' => 'Pending',
        'Cancelled' => 'Cancelled',
        'Failed' => 'Failed',
        'Declined' => 'Declined',
        'Rejected' => 'Rejected',
        'Success' => 'Success',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function sportsBilling(){
        return $this->belongsTo(SportsBilling::class,'sports_bill_id');
    }
}
