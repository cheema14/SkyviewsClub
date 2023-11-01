<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockIssueItem extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'stock_issue_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'item_id',
        'unit_id',
        'lot_no',
        'stock_required',
        'issued_qty',
        'stock_issue_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function item()
    {
        return $this->belongsTo(StoreItem::class, 'item_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function stock_issue()
    {
        return $this->belongsTo(StockIssue::class, 'stock_issue_id');
    }
}
