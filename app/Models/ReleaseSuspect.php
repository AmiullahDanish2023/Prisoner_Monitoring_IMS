<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class ReleaseSuspect extends Model
{
protected $fillable = [
    'suspect_id',
    'release_source_id', // ADD THIS
    'issued_or_transferred_number',
    'released_by',
    'release_date'
];



    public function suspect()
    {
        return $this->belongsTo(Suspect::class, 'suspect_id');
    }
     public function releaseSource()
{
    return $this->belongsTo(ReleaseSource::class, 'release_source_id');
}



public function getReleaseDateDariAttribute()
{
    if (!$this->release_date) {
        return null;
    }

    return CalendarUtils::strftime(
        'Y-m-d',
        strtotime($this->release_date)
    );
}



    
}
