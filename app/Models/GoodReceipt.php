<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodReceipt extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'good_receipts';

    public const PAY_TYPE_SELECT = [
        'Cash'   => 'Cash',
        'Credit' => 'Credit',
    ];

    protected $dates = [
        'gr_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'gr_number',
        'store_id',
        'gr_date',
        'vendor_id',
        'remarks',
        'pay_type',
        'gr_bill_no',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function grGrItemDetails()
    {
        return $this->hasMany(GrItemDetail::class, 'gr_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function getGrDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setGrDateAttribute($value)
    {
        $this->attributes['gr_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
