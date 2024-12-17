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
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Employee extends Model implements HasMedia
{
    use SoftDeletes, HasFactory, InteractsWithMedia, BelongsToTenant;

    public $table = 'employees';

    protected $appends = [
        'employee_photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'father_name',
        'phone',
        'cell_number',
        'designation',
        'employee_type',
        'job_type',
        'service_no',
        'joining_date',
        'date_of_birth',
        'religion',
        'cnic_no',
        'address',
        'temp_address',
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
        'salary',
        'salary_mode',
        'bank_name',
        'bank_account_no',
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

    public const SALARY_MODE = [
        'CASH' => 'CASH',
        'CHEQUE' => 'CHEQUE',
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
        $this->attributes['joining_date'] = $value ? Carbon::createFromFormat(config('panel.employee_birth_date_format'), $value)->format('Y-m-d') : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.employee_birth_date_format'), $value)->format('Y-m-d') : null;
    }

    // public function addMediaWithTenant($file)
    // {
    //     $this->media()->where('tenant_id', tenant()->id)->addMedia($file)->toMediaCollection('employee_photo');
    // }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 300, 300);
        //$this->addMediaConversion('profile')->fit('crop', 300, 300);

        // Apply the custom scope to ignore tenancy filtering
        // static::addGlobalScope('ignoreTenancy', function (Builder $builder) {
        //     $builder->ignoreTenancy();
        // });
    }

    public function getEmployeePhotoAttribute()
    {

        $file = $this->getMedia('employee_photo')?->last();
        
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->hasGeneratedConversion('thumb') ? $file->getUrl('thumb') : null;
            $file->preview = $file->hasGeneratedConversion('preview') ? $file->getUrl('preview') : null;
            // $file->small = $file->hasGeneratedConversion('small') ? $file->getUrl('small') : null;
        }

        return $file;
    }
}
