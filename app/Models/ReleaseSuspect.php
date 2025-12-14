<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ReleaseSuspect extends Model
{
   protected $fillable = [
    'suspect_id',
    'issued_or_transferred_number',
    'released_by',
    'release_date'
];


    public function suspect()
    {
        return $this->belongsTo(Suspect::class, 'suspect_id');
    }

    
}
