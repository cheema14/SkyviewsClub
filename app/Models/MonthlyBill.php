<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class MonthlyBill extends Model
{
    use SoftDeletes,HasFactory, BelongsToTenant;

    public $table = 'monthly_bills';

    protected $dates = [
        'bill_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bill_date',
        'membership_no',
        'billing_amount',
        'created_at',
        'updated_at',
        'deleted_at',
        'status',
        'member_id',
    ];

    public const STATUS_SELECT = [
        'ADDED'       => 'ADDED',
        'PENDING'  => 'PENDING',
        'Unpaid'  => 'Unpaid',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getBillDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBillDateAttribute($value)
    {
        $this->attributes['bill_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
