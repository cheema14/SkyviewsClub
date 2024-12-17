<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EmployeeDependent extends Model
{
    use HasFactory,SoftDeletes, BelongsToTenant;
    
    public $table = 'employees_dependents';

    const RELATION_SELECT = [
        'Husband' => 'Husband', 
        'Wife' => 'Wife' , 
        'Son' => 'Son',
        'Daughter' => 'Daughter'        
    ];

    const RELGION_SELECT = [
        'Islam'=>'Islam',
        'Christian'=>'Christian',
        'Hindu'=>'Hindu',
        'Sikh'=>'Sikh',
        'Ahmadi'=>'Ahmadi',
        'Budhist' => 'Budhist',        
    ];

    public const GENDER_SELECT = [
        'M' => 'Male',
        'F' => 'Female',
        'T' => 'Transgender',
    ];

    protected $fillable = [
        'name',
        'cnic',
        'cell_no',
        'marriage_date',
        'marriage_place',
        'address',
        'nationality',
        'religion',
        'cast',
        'gender',
        'profession',
        'relation',
        'date_of_birth',
        'employee_id',
        'deleted_at',
    ];

    protected $dates = [
        'date_of_birth',
        'marriage_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
