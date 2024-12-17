<?php

namespace App\Models;

use App\Models\MenuItemCategory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Menu extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'menus';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'summary',
        'created_at',
        'updated_at',
        'deleted_at',
        'has_discount',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function menuItems()
    {
        return $this->belongsToMany(Item::class);
    }

    public function menuCategories(){
        return $this->belongsToMany(MenuItemCategory::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'menu_role');
    }

}
