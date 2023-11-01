<?php

namespace App\Models;

use App\Models\Order;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'menu_item_category_id',
        'summary',
        'price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function menu_item_category()
    {
        return $this->belongsTo(MenuItemCategory::class, 'menu_item_category_id');
    }

    public function itemOrderItems(){
        return $this->belongsToMany(Order::class, 'order_items');
    }
}
