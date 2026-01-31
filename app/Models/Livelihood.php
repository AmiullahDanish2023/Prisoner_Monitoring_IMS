<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livelihood extends Model
{
   protected $fillable = [
    'livelihoodDate', 'week_day_id', 'amount',
    'rice','sugar','green_tea','beans','chickpeas',
    'milk_powder','eggs','oil','mutton','chicken','beef','cake','yogurt_drink','dates','sweets',
    'eggplant','zucchini','potato','potato_cooked','fasila','onion','tomato','cucumber','salad','lemon',
    'salt','raisin_rice','dry_bread','spice_pot','gas'
];



    public function weekDay()
    {
        return $this->belongsTo(WeekDay::class);
    }
}
