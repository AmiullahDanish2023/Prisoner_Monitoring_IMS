<?php

namespace App\Http\Controllers;

use App\Models\Livelihood;
use App\Models\WeekDay;
use App\Models\suspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;


class LivelihoodPlanController extends Controller
{


    public function monthlyReport()
    {
        $data = Livelihood::select(
            DB::raw('SUBSTRING(livelihoodDate, 1, 7) as month'),
            DB::raw('COUNT(id) as days_count'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('MAX(livelihoodDate) as livelihoodDate')
        )
            ->groupBy(DB::raw('SUBSTRING(livelihoodDate, 1, 7)'))
            ->orderBy('livelihoodDate', 'desc')
            ->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('week_name', function () {
                return '—';
            })
            ->addColumn('action', function ($row) {



                $month = $row->month;

                $btn  = "<div class='action-buttons'>";

                // View Monthly Records
                $btn .= "<a class='view-btn btn btn-sm'
                        href='" . route('livelihood.month.details', $month) . "'
                        data-title=' د مکملې هفتې د پلان تفصیل کتل'>
                        د پلان تفصیل
                    </a>";

                // Monthly PDF
                $btn .= "<a class='btn btn-warning btn-sm'
                    href='" . route('livelihood.month.pdf', $month) . "'
                   data-title='میاشتني راپور جوړول'>
                 میاشتني راپور
                 </a>";


                // Delete Monthly Records
                $btn .= "<a class='btn btn-danger btn-sm delete-month'
                        data-month='{$month}'
                        data-title='حذف راپور'>
                        حذف
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

    public function monthlyDetails($month)
    {
        $livelihoods = Livelihood::with('weekDay')
            ->where('livelihoodDate', 'like', $month . '%')
            ->orderBy('livelihoodDate')
            ->get();

        return view('LiveLiHood.livelihood_month_details', compact('livelihoods', 'month'));
    }

    public function deleteMonth($month)
    {
        Livelihood::where('livelihoodDate', 'like', $month . '%')->delete();

        return response()->json([
            'status' => true,
            'message' => 'د میاشت راپور حذف شو'
        ]);
    }

    public function edit($id)
    {
        $livelihood = Livelihood::findOrFail($id);
        $weekDays = WeekDay::all();

        // extract month from shamsi date
        $month = substr($livelihood->livelihoodDate, 0, 7);

        return view('LiveLiHood.livelihood_edit', compact('livelihood', 'month', 'weekDays'));
    }

    public function update(Request $request, $id)
    {
        $livelihood = Livelihood::findOrFail($id);

        $fields = [
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

        $data = [
            'amount'         => $request->amount,
            'livelihoodDate' => $request->livelihoodDate,
            'week_day_id'    => $request->week_day_id,
        ];

        foreach ($fields as $field) {
            // 🔴 null یا empty → 0
            $data[$field] = $request->filled($field) ? $request->$field : 0;
        }

        $livelihood->update($data);


        return response()->json([
            'status' => true,
            'message' => '✔ د بدل اعاشې ورځني پلان په بریالیتوب سره تغیر شو'
        ]);
    }







    public function monthlyLivelihoodPdf($month)
    {
        // =========================
        // میاشت start & end
        // =========================
        [$year, $mon] = explode('-', $month);

        $startJalali = Jalalian::fromFormat('Y-m-d', "$year-$mon-01");
        $endJalali   = $startJalali->addMonths(1)->subDays(1);

        $startDate = $startJalali->toCarbon()->startOfDay();
        $endDate   = $endJalali->toCarbon()->endOfDay();

        // =========================
        // ۷ ورځنی پلان
        // =========================
        $weekPlans = Livelihood::with('weekDay')
            ->orderBy('week_day_id')
            ->take(7)
            ->get();

        if ($weekPlans->count() < 7) {
            abort(404, 'باید مکمل ۷ ورځنی پلان موجود وي');
        }

        // =========================
        // خوراکي توکي
        // =========================
        $items = [
            'rice'          => 'برنج سیله',
            'sugar'         => 'بوره',
            'green_tea'     => 'چای سبز',
            'beans'         => 'لوبیا',
            'chickpeas'     => 'نخود',
            'milk_powder'   => 'شیر خشک',
            'eggs'          => 'تخم مرغ',
            'oil'           => 'روغن',
            'mutton'        => 'گوشت گوسفند',
            'chicken'       => 'گوشت مرغ',
            'beef'          => 'گوشت گاو',
            'cake'          => 'کیک',
            'yogurt_drink'  => 'دوغ',
            'dates'         => 'خرما',
            'sweets'        => 'شیرینی',
            'eggplant'      => 'بانجن سیاه',
            'zucchini'      => 'کدو',
            'potato'        => 'کچالو',
            'potato_cooked' => 'کچالو جوشک',
            'fasila'        => 'فاصیله',
            'onion'         => 'پیاز',
            'tomato'        => 'رومی',
            'cucumber'      => 'بادرنګ',
            'salad'         => 'سلات',
            'lemon'         => 'لیمو',
            'salt'          => 'نمک',
            'raisin_rice'   => 'کشمش پلو',
            'dry_bread'     => 'نان خشک',
            'spice_pot'     => 'مساله دیگ',
            'gas'           => 'گاز',
        ];

        // =========================
        // init totals
        // =========================
        $totals = array_fill_keys(array_keys($items), 0);
        $totals['persons'] = 0;
        $totals['amount']  = 0;

        $rows = [];
        $dayNo = 1;

        // =========================
        // loop month days
        // =========================
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

            $male = Suspect::where('status', 'prisoner')
                ->where('gender', 'نارینه')
                ->whereDate('monitoring_date', $date)
                ->count();

            $female = Suspect::where('status', 'prisoner')
                ->where('gender', 'ښځینه')
                ->whereDate('monitoring_date', $date)
                ->count();

            $kids = Suspect::where('status', 'prisoner')
                ->whereDate('monitoring_date', $date)
                ->sum('children_with_mother');

            $persons = $male + $female + $kids;

            // د اونۍ ورځ مطابق پلان
            $plan = $weekPlans[$date->dayOfWeekIso - 1];

            $amount = $plan->amount * $persons;

            $row = [
                'no'      => $dayNo,
                'date'    => Jalalian::fromCarbon($date)->format('Y/m/d'),
                'weekday' => $plan->weekDay->name,
                'persons' => $persons,
                'amount'  => $amount,
            ];

            foreach ($items as $field => $label) {
                $value = $plan->$field * $persons;
                $row[$field] = $value;
                $totals[$field] += $value;
            }

            $totals['persons'] += $persons;
            $totals['amount']  += $amount;

            $rows[] = $row;
            $dayNo++;
        }

        return PDF::loadView(
            'LiveLiHood.livelihood_monthly_pdf',
            compact('rows', 'items', 'totals', 'month'),
            [],
            [
                'orientation' => 'L',
                'format'      => 'A4',
            ]
        )->stream("Monthly_Livelihood_$month.pdf");
    }


  public function weeklyReportPdf($id)
{
    $record = Livelihood::findOrFail($id);

   
    $jalaliDate = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d', $record->livelihoodDate);
    $startDate = $jalaliDate->toCarbon()->startOfWeek(\Carbon\Carbon::SATURDAY);
    $endDate   = $startDate->copy()->addDays(6);

   
    $weekPlans = Livelihood::with('weekDay')
        ->orderBy('week_day_id')
        ->take(7)
        ->get();

    if ($weekPlans->count() < 7) {
        abort(404, 'باید مکمل ۷ ورځنی پلان موجود وي');
    }

   
    $items = [
            'rice'          => 'برنج سیله',
            'sugar'         => 'بوره',
            'green_tea'     => 'چای سبز',
            'beans'         => 'لوبیا',
            'chickpeas'     => 'نخود',
            'milk_powder'   => 'شیر خشک',
            'eggs'          => 'تخم مرغ',
            'oil'           => 'روغن',
            'mutton'        => 'گوشت گوسفند',
            'chicken'       => 'گوشت مرغ',
            'beef'          => 'گوشت گاو',
            'cake'          => 'کیک',
            'yogurt_drink'  => 'دوغ',
            'dates'         => 'خرما',
            'sweets'        => 'شیرینی',
            'eggplant'      => 'بانجن سیاه',
            'zucchini'      => 'کدو',
            'potato'        => 'کچالو',
            'potato_cooked' => 'کچالو جوشک',
            'fasila'        => 'فاصیله',
            'onion'         => 'پیاز',
            'tomato'        => 'رومی',
            'cucumber'      => 'بادرنګ',
            'salad'         => 'سلات',
            'lemon'         => 'لیمو',
            'salt'          => 'نمک',
            'raisin_rice'   => 'کشمش پلو',
            'dry_bread'     => 'نان خشک',
            'spice_pot'     => 'مساله دیگ',
            'gas'           => 'گاز',
        ];

    $totals = array_fill_keys(array_keys($items), 0);
    $totals['persons'] = 0;
    $totals['amount']  = 0;

    $rows = [];
    $dayNo = 1;

    // =========================
    // Loop 7 Days
    // =========================
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

        $male = Suspect::where('status', 'prisoner')
            ->where('gender', 'نارینه')
            ->whereDate('monitoring_date', $date)
            ->count();

        $female = Suspect::where('status', 'prisoner')
            ->where('gender', 'ښځینه')
            ->whereDate('monitoring_date', $date)
            ->count();

        $kids = Suspect::where('status', 'prisoner')
            ->whereDate('monitoring_date', $date)
            ->sum('children_with_mother');

        $persons = $male + $female + $kids;

        // د اونۍ ورځ مطابق پلان
        $plan = $weekPlans[$date->dayOfWeekIso - 1];

        $amount = $plan->amount * $persons;

        $row = [
            'no'      => $dayNo,
            'date'    => \Morilog\Jalali\Jalalian::fromCarbon($date)->format('Y/m/d'),
            'weekday' => $plan->weekDay->name ?? '',
            'persons' => $persons,
            'amount'  => $amount,
        ];

        foreach ($items as $field => $label) {
            $value = ($plan->$field ?? 0) * $persons; // safety null check
            $row[$field] = $value;
            $totals[$field] += $value;
        }

        $totals['persons'] += $persons;
        $totals['amount']  += $amount;

        $rows[] = $row;
        $dayNo++;
    }

    // =========================
    // Week range for header
    // =========================
    $weekRange =
        \Morilog\Jalali\Jalalian::fromCarbon($startDate)->format('Y/m/d')
        . ' - ' .
        \Morilog\Jalali\Jalalian::fromCarbon($endDate)->format('Y/m/d');

    // =========================
    // Generate PDF
    // =========================
    return PDF::loadView(
        'LiveLiHood.livelihood_weekly_pdf',
        compact('rows', 'items', 'totals', 'weekRange'),
        [],
        [
            'format' => 'A4',
            'orientation' => 'L',
            'default_font' => 'dejavusans', // Pashto font support
        ]
    )->stream("Weekly_Livelihood_Report.pdf");
}

}
