<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class suspect extends Model
{
    use HasFactory;
    public function provinceRelation()
    {
        return $this->belongsTo(Province::class, 'province');
    }

    public function release()
    {
        return $this->hasOne(ReleaseSuspect::class, 'suspect_id');
    }



    public function getMonitoringDateDariAttribute()
    {
        if (!$this->monitoring_date) {
            return null;
        }

        return CalendarUtils::strftime(
            'Y-m-d',
            strtotime($this->monitoring_date)
        );
    }

    // protected $casts = [
    //     'has_items' => 'boolean',
    // ];

    protected $casts = [
    'has_items' => 'integer',
];
}
