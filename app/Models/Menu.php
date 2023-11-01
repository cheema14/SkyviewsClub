<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\MenuItemCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use SoftDeletes, HasFactory;

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

}
