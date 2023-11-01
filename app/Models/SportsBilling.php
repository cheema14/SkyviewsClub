<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SportsBilling extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'sports_billings';

    protected $dates = [
        'bill_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const PAY_MODE_SELECT = [
        'cash' => 'Cash',
        'card' => 'Card',
        'credit' => 'Credit',
    ];

    protected $fillable = [
        'member_name',
        'membership_no',
        'non_member_name',
        'bill_date',
        'bill_number',
        'remarks',
        'ref_club',
        'club_id_ref',
        'tee_off',
        'holes',
        'caddy',
        'temp_mbr',
        'temp_caddy',
        'pay_mode',
        'gross_total',
        'total_payable',
        'bank_charges',
        'net_pay',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function sportBillingSportBillingItems()
    {
        return $this->hasMany(SportBillingItem::class, 'billing_issue_item_id', 'id');
    }

    public function sportsBill()
    {
        return $this->hasMany(Member::class, 'membership_no', 'membership_no');
    }
}
