<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockIssue extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'stock_issues';

    protected $dates = [
        'issue_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'issue_no',
        'issue_date',
        'section_id',
        'store_id',
        'employee_id',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function stockIssueStockIssueItems()
    {
        return $this->hasMany(StockIssueItem::class, 'stock_issue_id', 'id');
    }

    public function getIssueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setIssueDateAttribute($value)
    {
        $this->attributes['issue_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
