<?php

namespace App\Rules;

use App\Models\PaymentReceipt;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueMonthlyMemberArrearRequest implements ValidationRule
{
    protected $billDate;
    protected $membershipNo;
    protected $payMode;

    public function __construct($billDate,$membershipNo,$payMode){
        $this->billDate = $billDate;
        $this->membershipNo = $membershipNo;
        $this->payMode = $payMode;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Parse the date value
        $date = \Carbon\Carbon::parse($value);
        if (PaymentReceipt::whereYear('receipt_date', $date->year)
        ->whereMonth('receipt_date', $date->month)
        ->where('member_id', $this->membershipNo)
        ->where('pay_mode', $this->payMode)
        ->exists()) {
            $fail('Arrears for this member already exists.');
        }
        
    }
}
