<?php

namespace App\Models;

use App\Models\Menu;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class MenuItemCategory extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'menu_item_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function menuItemCategoryItems()
    {
        return $this->hasMany(Item::class, 'menu_item_category_id', 'id');
    }

    public function menus(){
        return $this->belongsToMany(Menu::class);
    }
}
