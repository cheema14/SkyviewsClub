<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'employees';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'father_name',
        'phone',
        'designation',
        'employee_type',
        'job_type',
        'service_no',
        'joining_date',
        'date_of_birth',
        'religion',
        'cnic_no',
        'address',
        'department',
        'section',
        'gender',
        'marital_status',
        'blood_group',
        'nationality',
        'domicile',
        'qualification',
        'current_salary',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const EMPLOYEE_TYPE = [
        'Armed-Forces' => 'Armed Forces',
        'Civil' => 'Civil',
    ];

    public const GENDER_SELECT = [
        'M' => 'Male',
        'F' => 'Female',
        'T' => 'Transgender',
    ];

    public const DEPARTMENT_SELECT = [
        'Department-one' => 'Department One',
        'Department-two' => 'Department Two',
        'Department-three' => 'Department three',
    ];

    public const SECTION_SELECT = [
        'Section-one' => 'Section One',
        'Section-two' => 'Section Two',
        'Section-three' => 'Section three',
    ];

    public const MARITAL_SELECT = [
        'Single' => 'Single',
        'Married' => 'Married',
        'Divorced' => 'Divorced',
        'Separated' => 'Separated',
    ];

    public const RELIGION_SELECT = [
        'Islam' => 'Islam',
        'Christianity' => 'Christianity',
        'Hindu' => 'Hindu',
        'Other' => 'Other',
    ];

    public const BLOOD_GROUP_SELECT = [
        'A+' => 'A Positive',
        'A-' => 'A Negative',
        'B+' => 'B Positive',
        'B-' => 'B Negative',
        'AB+' => 'AB Positive',
        'AB-' => 'AB Negative',
        'O+' => 'O Positive',
        'O-' => 'O Negative',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = $value ? Carbon::createFromFormat(config('panel.birth_date_format'), $value)->format('Y-m-d') : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.birth_date_format'), $value)->format('Y-m-d') : null;
    }
}
