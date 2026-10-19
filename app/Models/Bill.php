<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bill_number',
        'shop_name',
        'shop_address',
        'shop_phone',
        'bill_date',
        'total_amount',
        'payment_method', // نقد، پور، کارت
        'responsible_person',
        'note',
        'status', // فعال، لغو شوی
        'user_id', // د ثبت کوونکي کارن
    ];

    protected $casts = [
        'bill_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        // کله چې بیل حذف شي (Soft Delete)
        static::deleting(function ($bill) {
            // که forceDelete وي، اړوند ریکارډونه په بشپړه توګه حذف کړه
            if ($bill->isForceDeleting()) {
                // د عکسونو فزیکي فایلونه حذف کول
                foreach ($bill->images as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                }

                // د اړوندو ریکارډونو په بشپړه توګه حذف کول
                $bill->images()->forceDelete();
                $bill->items()->forceDelete();
            }
        });
    }

    // د بیل او اجناسو اړیکه
    public function items()
    {
        return $this->hasMany(BillItem::class);
    }

    // د بیل او عکسونو اړیکه
    public function images()
    {
        return $this->hasMany(BillImage::class);
    }

    // د بیل او کارن اړیکه
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // د مجموعي قیمت محاسبه
    public function calculateTotal()
    {
        return $this->items()->sum('total_price');
    }

    // د تاریخ له مخې فلتر
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('bill_date', [$startDate, $endDate]);
    }

    // د دوکان له مخې فلتر
    public function scopeShopName($query, $shopName)
    {
        return $query->where('shop_name', 'like', '%' . $shopName . '%');
    }

    // د میاشتې له مخې فلتر
    public function scopeMonth($query, $year, $month)
    {
        return $query->whereYear('bill_date', $year)->whereMonth('bill_date', $month);
    }
}
