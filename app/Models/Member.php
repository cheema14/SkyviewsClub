<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Member extends Authenticatable implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory, HasApiTokens;

    public $table = 'members';

    protected $appends = [
        'photo',
        'signature',
        'cnic_front',
        'cnic_back',
    ];

    const STATUS_COLOR = [
        'Active' => '#90EE90',
        'Sleeping' => '#00BFFF',
        'Cancelled' => '#FFFF99',
        'Blocked' => '#ff040463',
    ];

    public const GENDER_SELECT = [
        'M' => 'Male',
        'F' => 'Female',
        'T' => 'Transgender',
    ];

    public const SERVING_OFFICER_TYPE = [
        'Army Serving' => 'Army Serving',
        'Navy Serving' => 'Navy Serving',
        'PAF Serving' => 'PAF Serving',
        'Staff' => 'Staff',
        'Others' => 'Others',
    ];

    public const PRESENT_STATUS_SELECT = [
        'serving' => 'Serving',
        'retired' => 'Retired',
        'N/A' => 'N/A',
    ];

    protected $dates = [
        'date_of_birth',
        'date_of_membership',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const GOLF_H_CAP_SELECT = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
        '32' => '32',
        '33' => '33',
        '34' => '34',
        '35' => '35',
        '36' => '36',
        'N/A' => 'N/A',
    ];

    public const BPS_SELECT = [
        'BPS-16' => 'BPS-16',
        'BPS-17' => 'BPS-17',
        'BPS-18' => 'BPS-18',
        'BPS-19' => 'BPS-19',
    ];

    public const MEMBERSHIP_STATUS_SELECT = [
        'Active' => 'Active',
        'Sleeping' => 'Sleeping',
        'Cancelled' => 'Cancelled',
        'Blocked' => 'Blocked',
    ];

    protected $fillable = [
        'name',
        'designation_id',
        'bps',
        'department_id',
        'membership_no',
        'mailing_address',
        'telephone_off',
        'cell_no',
        'email_address',
        'cnic_no',
        'special_instructions',
        'pak_svc_no',
        'husband_father_name',
        'gender',
        'date_of_birth',
        'qualification',
        'station_city',
        'present_status',
        'membership_category_id',
        'membership_type_id',
        'membership_status',
        'tel_res',
        'date_of_membership',
        'golf_h_cap',
        'nationality',
        'permanent_address',
        'membership_fee',
        'created_at',
        'updated_at',
        'deleted_at',
        'password',
        'monthly_type',
        'monthly_subscription_revised',
        'arrears',
        'member_age',
        'payment_method',
        'organization',
        'member_security_fee',
        'is_non_member',
        'serving_officer_type',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 300, 300);
        // $this->addMediaConversion('profile')->fit('crop', 300, 300);
    }

    public function memberOrders()
    {
        return $this->hasMany(Order::class, 'member_id', 'id');
    }

    public function completedOrders()
    {
        return $this->hasMany(Order::class, 'member_id', 'id')->where(['orders.status' => 'Complete', 'transactions.status' => 'Pending']);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getPhotoAttribute()
    {

        $file = $this->getMedia('photo')?->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
            // $file->small   = $file->getUrl('small');
        }

        return $file;
    }

    public function getCnicFrontAttribute()
    {

        $file = $this->getMedia('cnic_front')?->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function getCnicBackAttribute()
    {

        $file = $this->getMedia('cnic_back')?->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.birth_date_format'), $value)->format('Y-m-d') : null;
    }

    public function membership_category()
    {
        return $this->belongsTo(MembershipCategory::class, 'membership_category_id');
    }

    public function membership_type()
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    public function getDateOfMembershipAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfMembershipAttribute($value)
    {
        $this->attributes['date_of_membership'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getSignatureAttribute()
    {
        $file = $this->getMedia('signature')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function latestBill()
    {
        return $this->hasOne(Bill::class)->latestOfMany();
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Order::class);
    }

    public function pendingTransactions()
    {
        return $this->hasManyThrough(Transaction::class, Order::class)->where('transactions.status', 'Pending');
    }

    public function creditOnlyTransactions()
    {
        $where = [
            'transactions.status' => 'Success',
            'transactions.type' => 'Credit',
        ];

        return $this->hasManyThrough(Transaction::class, Order::class)->where($where);
    }

    public function sportsBill()
    {
        $where = ['pay_mode' => 'credit'];

        return $this->hasOne(SportsBilling::class, 'membership_no', 'membership_no')->where($where);
    }
}
