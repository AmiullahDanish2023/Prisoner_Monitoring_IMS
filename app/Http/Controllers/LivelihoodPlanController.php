<?php

namespace App\Http\Controllers;

use App\Models\Livelihood;
use App\Models\WeekDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivelihoodPlanController extends Controller
{


    public function weeklyReport()
    {
        $data = Livelihood::join('week_days', 'livelihoods.week_day_id', '=', 'week_days.id')
            ->select(
                'week_days.id as week_id',
                'week_days.name as week_name',
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(livelihoods.id) as days_count'),
                DB::raw('MAX(livelihoods.livelihoodDate) as livelihoodDate')

            )
            ->groupBy('week_days.id', 'week_days.name')
            ->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                // Wrap all buttons in a flex container for proper spacing
                $btn = "<div class='action-buttons'>";




                // Edit Button
                $btn .= "<a class='edit-btn btn btn-outline-info btn-sm' data-title='د معلوماتو تغیرول'  style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;'" . $row->id . "'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <path d='M12 20h9'/>
                            <path d='M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z'/>
                        </svg>
                    </a>";

                // Delete Button
                $btn .= "<a class='destroy_btn btn btn-sm btn-outline-danger' data-title='د ریکارډ حذفول' style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;' data-id='" . $row->id . "'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <polyline points='3 6 5 6 21 6'/>
                            <path d='M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6'/>
                            <path d='M10 11v6'/>
                            <path d='M14 11v6'/>
                            <path d='M9 6V4a2 2 0 0 1 2-2h2a2 2 0_0_1_2_2v2'/>
                        </svg>
                    </a>";

                // Print Button – Classic
                $btn .= "
      <a class='view-btn btn btn-outline-success btn-sm'
           title='چاپ'
             style='cursor:pointer; display:inline-flex; align-items:center; justify-content:center;
          width:34px; height:34px; padding:0; margin-left:5px;'>

             <svg xmlns='http://www.w3.org/2000/svg'
         width='18' height='18'
         viewBox='0 0 24 24'
         fill='none'
         stroke='currentColor'
         stroke-width='2'
         stroke-linecap='round'
         stroke-linejoin='round'>
        <polyline points='6 9 6 2 18 2 18 9'/>
        <path d='M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2'/>
        <rect x='6' y='14' width='12' height='8'/>
          </svg>
     </a>";





                $btn .= "</div>";


                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

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
                $data[$field] = $request->$field ?? 1;
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

    public function livelihoodShow()
    {

        $livelihoods = Livelihood::with('weekDay')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('livelihoods')
                    ->groupBy(DB::raw('SUBSTRING(livelihoodDate, 1, 7)'));
            })
            ->orderBy('livelihoodDate')
            ->get();

      return view('LiveLiHood.livelihood_list', compact('livelihoods'));

    }
}
