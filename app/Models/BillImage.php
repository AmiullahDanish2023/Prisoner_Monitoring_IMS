<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bill_id',
        'image_path',
        'image_name',
        'is_primary', // لومړنی عکس
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    // د عکس بشپړ URL ترلاسه کول
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}