<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MemberDependents extends Model
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'members_dependents';

    protected $appends = [
        'photod'
    ];

    protected $fillable = [
        'dep_name',
        'dep_age',
        'dep_occupation',
        'dep_relation',
        'dep_dob',
        'dep_gender',
        'dep_nationality',
        'dep_gold_hcap',
        
    ];


    public function getPhotodAttribute()
    {
        $file = $this->getMedia('photod')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
}
