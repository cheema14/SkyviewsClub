<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_COLOR = [
        'New' => '#3CC7ED',
        'Active' => '#f1c232',
        'Paid' => '#f44336',
        'Delivered' => '#c90076',
        'Returned' => '#d9d2e9',
        'Complete' => '#38761d',
    ];

    public const STATUS_SELECT = [
        'New' => 'New',
        'Active' => 'Active',
        'Paid' => 'Paid',
        'Delivered' => 'Delivered',
        'Returned' => 'Returned',
        'Complete' => 'Complete',
    ];

    protected $fillable = [
        'user_id',
        'member_id',
        'status',
        'item_discount',
        'sub_total',
        'tax',
        'total',
        'promo',
        'discount',
        'grand_total',
        'created_at',
        'updated_at',
        'deleted_at',
        'table_top_id',
        'check_in',
        'check_out',
        'no_of_guests',
        'payment_type',
    ];

    protected static function booted()
    {
        static::updating(function ($order) {
            if ($order->isDirty('table_top_id')) {
                $oldTableTopId = $order->getOriginal('table_top_id');

                // Update the status of the previous table_top_id to "free"
                TableTop::where('id', $oldTableTopId)
                    ->update(['status' => 'free']);

                // Update the status of the new table_top_id to "active"
                TableTop::where('id', $order->table_top_id)
                    ->update(['status' => 'active']);
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot(['price', 'quantity', 'content', 'discount', 'menu_id']);
    }

    public function getPivotAttributesAttribute()
    {
        return $this->items->map(function ($item) {
            return [
                'price' => $item->pivot->price,
                'quantity' => $item->pivot->quantity,
                'content' => $item->pivot->content,
                'discount' => $item->pivot->discount,
                'menu_id' => $item->pivot->menu_id,
            ];
        });
    }

    public function orderTransactions()
    {
        return $this->hasMany(Transaction::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function tableTop()
    {
        return $this->belongsTo(TableTop::class, 'table_top_id', 'id');
    }

    public function latestTransaction()
    {
        return $this->hasOne(Transaction::class)->latestOfMany();
    }
}
