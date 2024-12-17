<?php

namespace App\Rules;

use App\Models\MonthlyBill;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueMonthlyBillRequest implements ValidationRule
{
    protected $billDate;
    protected $membershipNo;

    public function __construct($billDate, $membershipNo)
    {
        $this->billDate = $billDate;
        $this->membershipNo = $membershipNo;
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
        
        // Check if a bill already exists for this month
        if (MonthlyBill::whereYear('bill_date', $date->year)
        ->whereMonth('bill_date', $date->month)
        ->where('membership_no', $this->membershipNo)
        ->exists()) {
            $fail('Monthly Arrears for this user already exists.');
        }
    }
}
