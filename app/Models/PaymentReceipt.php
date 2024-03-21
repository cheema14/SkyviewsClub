<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PaymentReceipt extends Model implements HasMedia
{
    use  InteractsWithMedia, HasFactory;

    public $table = 'payment_receipts';

    protected $appends = [
        'cheque_photo',
        'deposit_photo',
    ];

    public const PAY_MODE = [
        'Cash' => 'Cash',
        'OnlineTransfer' => 'Online Transfer',
        'Transfer' => 'Transfer',
        'Cheque' => 'Cheque',
    ];

    public const BANK_NAMES = [
        'AlBaraka' => 'Al Baraka Bank (Pakistan) Limited',
        'Allied' => 'Allied Bank Limited (ABL)',
        'Askari' => 'Askari Bank',
        'Alfalah' => 'Bank Alfalah Limited (BAFL)',
        'AlHabib' => 'Bank Al-Habib Limited (BAHL)',
        'BankIslami' => 'BankIslami Pakistan Limited',
        'BOP' => 'Bank of Punjab (BOP)',
        'BOK' => 'Bank of Khyber',
        'DubaiIslamic' => 'Dubai Islamic Bank Pakistan Limited (DIB Pakistan)',
        'Faysal' => 'Faysal Bank Limited (FBL)',
        'FirstWomen' => 'First Women Bank Limited',
        'HBL' => 'Habib Bank Limited (HBL)',
        'HabibMetro' => 'Habib Metropolitan Bank Limited',
        'JS' => 'JS Bank Limited',
        'MCB' => 'MCB Bank Limited',
        'MCBIslamic' => 'MCB Islamic Bank Limited',
        'Meezan' => 'Meezan Bank Limited',
        'NBP' => 'National Bank of Pakistan (NBP)',
        'Summit' => 'Summit Bank Pakistan',
        'Standard' => 'Standard Chartered Bank (Pakistan) Limited (SC Pakistan)',
        'Sindh' => 'Sindh Bank',
        'UBL' => 'United Bank Limited (UBL)',
        'ZaraiTaraqiati' => 'Zarai Taraqiati Bank Limited',
    ];

    protected $fillable = [
        'receipt_no',
        'receipt_date',
        'bill_type',
        'billing_month',
        'invoice_number',
        'invoice_amount',
        'pay_mode',
        'received_amount',
        'cheque_number',
        'bank_name',
        'cheque_date',
        'deposit_slip_number',
        'deposit_bank_name',
        'deposit_date',
        'user_id',
        'bill_id',
        'member_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 300, 300);
    }

    public function getChequePhotoAttribute()
    {

        $file = $this->getMedia('cheque_photo')?->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
            // $file->small   = $file->getUrl('small');
        }

        return $file;
    }

    public function getDepositPhotoAttribute()
    {

        $file = $this->getMedia('deposit_photo')?->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
            // $file->small   = $file->getUrl('small');
        }

        return $file;
    }

    public function setChequeDateAttribute($value)
    {
        $this->attributes['cheque_date'] = $value ? Carbon::createFromFormat(config('panel.birth_date_format'), $value)->format('Y-m-d') : null;
    }

    public function getChequeDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDepositDateAttribute($value)
    {
        $this->attributes['deposit_date'] = $value ? Carbon::createFromFormat(config('panel.birth_date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDepositDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    // Relationships with other models
    /* 
        1. User Model (Who created receipt)
        2. Member Model
        3. Bill Model
        4. Transaction Model
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function bill(){
        return $this->belongsTo(Bill::class,'bill_id');
    }


}
