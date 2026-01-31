<?php

namespace App\Http\Controllers;

use App\Models\Livelihood;
use App\Models\WeekDay;
use Illuminate\Http\Request;

class LivelihoodPlanController extends Controller
{
    public function livelihoodPlan()
    {
        $weekDays = WeekDay::all();
        return view('LiveLiHood.livelihood_plan', compact('weekDays'));
    }

    /* ===================== STORE ===================== */
    public function store(Request $request)
    {
        
        $fields = [
            'livelihoodDate',
            'week_day_id',
            'amount',
            'rice',
            'sugar',
            'green_tea',
            'beans',
            'chickpeas',
            'milk_powder',
            'eggs',
            'oil',
            'mutton',
            'chicken',
            'beef',
            'cake',
            'yogurt_drink',
            'dates',
            'sweets',
            'eggplant',
            'zucchini',
            'potato',
            'potato_cooked',
            'fasila',
            'onion',
            'tomato',
            'cucumber',
            'salad',
            'lemon',
            'salt',
            'raisin_rice',
            'dry_bread',
            'spice_pot',
            'gas'
        ];

        
        $data = [];
        foreach ($fields as $field) {
            if ($field === 'week_day_id') {
                $data[$field] = $request->$field ?? 1; // put default week_day_id as 1 if not provided
            } elseif ($field === 'livelihoodDate') {
                $data[$field] = $request->$field ?? now(); 
            } else {
                $data[$field] = $request->$field !== null ? floatval($request->$field) : 0;
            }
        }

        $livelihood = new Livelihood();
        $livelihood->fill($data); 
        $livelihood->save();

        return response()->json([
            'status' => true,
            'message' => 'معلومات په بریالیتوب سره ثبت شول!'
        ]);
    }










    /* ===================== UPDATE ===================== */
}
