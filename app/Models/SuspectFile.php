<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspectFile extends Model
{
    use HasFactory;
    protected $fillable = ['suspect_id', 'file_path', 'file_type'];


    public function suspect()
    {
        return $this->belongsTo(Suspect::class);
    }
}
