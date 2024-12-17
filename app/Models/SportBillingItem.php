<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class SportBillingItem extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    public $table = 'sport_billing_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'billing_division_id',
        'billing_item_type_id',
        'billing_item_class_id',
        'billing_item_name_id',
        'quantity',
        'rate',
        'amount',
        'billing_issue_item_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function billing_division()
    {
        return $this->belongsTo(SportsDivision::class, 'billing_division_id');
    }

    public function billing_item_type()
    {
        return $this->belongsTo(SportItemType::class, 'billing_item_type_id');
    }

    public function billing_item_class()
    {
        return $this->belongsTo(SportItemClass::class, 'billing_item_class_id');
    }

    public function billing_item_name()
    {
        return $this->belongsTo(SportItemName::class, 'billing_item_name_id');
    }

    public function billing_issue_item()
    {
        return $this->belongsTo(SportsBilling::class, 'billing_issue_item_id');
    }

    public function sportBillingSportBillingItems()
    {
        return $this->hasMany(SportBillingItem::class, 'billing_issue_item_id', 'id');
    }
}
