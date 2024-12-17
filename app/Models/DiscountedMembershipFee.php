<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class DiscountedMembershipFee extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, BelongsToTenant;

    public $table = 'discounted_membership_fees';

    protected $fillable = [
        'member_id',
        'monthly_subscription_revised',
        'implemented_from',
        'no_of_months',
        'remaining_months',
        'is_active',
    ];

    protected $appends = [
        'absentees_application',
    ];

    public function getAbsenteesApplicationAttribute()
    {

        $file = $this->getMedia('absentees_application')?->last();
        if ($file) {
            $file->url = $file->getUrl();
            // $file->thumbnail = $file->getUrl('thumb');
            // $file->preview = $file->getUrl('preview');
        }

        return $file;
    }
}
