<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Bill extends Model
{
    use HasFactory,BelongsToTenant;

    public $table = 'bills';

    protected $fillable = [
        'user_id',
        'member_id',
        'balance_bfcr',
        'membership_installment',
        'monthly_subscription',
        'restaurant_fee',
        'total',
        'checque_no',
        'bill_month',
        'credit_amount',
        'net_balance_payable',
        'sports_bill',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'card_fee',
        'practice_range_coaching_fee',
        'locker_fee',
        'fee',
        'snooker_fee',
        'proshop_fee',
        'golf_simulator',
        'golf_locker',
        'golf_course',
        'golf_cart_fee',
    ];

    public const BILLING_MONTHS = [
        1 =>'Jan',
        2 =>'Feb',
        3 =>'Mar',
        4 =>'Apr',
        5 =>'May',
        6 =>'Jun',
        7 =>'Jul',
        8 =>'Aug',
        9 =>'Sep',
        10 =>'Oct',
        11 =>'Nov',
        12 =>'Dec',
    ];

    public const BILL_STATUS = [
        'Paid' => 'Paid',
        'Unpaid' => 'Unpaid',
        'Stalled' => 'Stalled',
        'Pending' => 'Pending',
        'Partial' => 'Partial',
        'Locked' => 'Locked',
    ];

    public function receipts(){
        return $this->hasMany(PaymentReceipt::class,'bill_id')->where('is_deducted', false);
    }

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
