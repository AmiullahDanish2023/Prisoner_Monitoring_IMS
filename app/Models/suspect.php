<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
