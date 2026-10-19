<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bill_id',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
        'description',
        'category', 
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    // د مجموعي قیمت محاسبه
    public static function calculateTotal($quantity, $unit_price)
    {
        return $quantity * $unit_price;
    }

    // د کټګوري له مخې فلتر
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // د جنس له مخې فلتر
    public function scopeItemName($query, $itemName)
    {
        return $query->where('item_name', 'like', '%' . $itemName . '%');
    }
}