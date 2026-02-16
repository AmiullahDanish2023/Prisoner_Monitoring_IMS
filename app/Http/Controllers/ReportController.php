<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suspect;
use App\Models\Province;
use App\Models\ReleaseSource;
use PDF;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;

class ReportController extends Controller
{

  public function to_esawi_date($date)
  {
    return Jalalian::fromFormat('Y-m-d', $date)->toCarbon();
  }

  public function to_dari_date($date)
  {
    return CalendarUtils::strftime('Y-m-d', strtotime($date));
  }

    public function generalReport()
    {
        $province = Province::all();
        return view('reports.general_report', compact('province'));
    }


    public function createGeneralReport(Request $request)
    {
        $start = null;
        $end   = null;

        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
        }

        $suspects = Suspect::leftJoin('release_suspects', 'suspects.id', '=', 'release_suspects.suspect_id')
            ->join('provinces', 'suspects.province', '=', 'provinces.id')
            ->whereNull('release_suspects.suspect_id')
            ->select(
                'suspects.*',
                'provinces.name_da as province_name'
            )
            ->when($request->province_id, function ($query) use ($request) {
                $query->where('suspects.province', $request->province_id);
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('suspects.monitoring_date', [$start, $end]);
            })
            ->when($request->gender, function ($query) use ($request) {
                $query->where('suspects.gender', $request->gender);
            })
            ->get();

        $province = null;
        if ($request->province_id) {
            $province = Province::find($request->province_id);
        }

        $pdf = PDF::loadView(
            'reports.general_report_pdf',
            compact('suspects', 'province', 'start', 'end')
        );

        return $pdf->stream('General_Suspects_Report.pdf');
    }



    // Existing Suspect PDF Report
    public function existingSuspectPdf(Request $request)
    {
        $baseQuery = Suspect::query();

        if ($request->province_id) {
            $baseQuery->where('province', $request->province_id);
        }

        // =========================
        // Male
        // =========================
        $today = Carbon::today();

        // Suspects registered before today
        $oldMaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '<', $today)
            ->where('gender', 'نارینه')
            ->count();


        $newMaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '=', $today)
            ->where('gender', 'نارینه')
            ->count();

        $oldFemaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '<', $today)
            ->where('gender', 'ښځینه')
            ->count();


        $newFemaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '=', $today)
            ->where('gender', 'ښځینه')
            ->count();

        $oldChildrenSuspects = (clone $baseQuery)
            ->whereDate('created_at', '<', $today)
            ->sum('children_with_mother');


        $newChildrenSuspects = (clone $baseQuery)
            ->whereDate('created_at', '=', $today)
            ->sum('children_with_mother');







        $maleReleasedToday = (clone $baseQuery)
            ->where('gender', 'نارینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'release')
                    ->whereDate('created_at', '=', $today)
            )->count();

        $maleTransferredToday = (clone $baseQuery)
            ->where('gender', 'نارینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'multi')
                    ->whereDate('created_at', '=', $today)
            )->count();

        $maleDetainedToday = (clone $baseQuery)
            ->where('gender', 'نارینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'detention')
                    ->whereDate('created_at', '=', $today)
            )->count();



        // Female
        // =========================


        $femaleReleasedToday = (clone $baseQuery)

            ->where('gender', 'ښځینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'release')
                    ->whereDate('created_at', '=', $today)
            )->count();

        $femaleTransferredToday = (clone $baseQuery)
            ->where('gender', 'ښځینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'multi')
                    ->whereDate('created_at', '=', $today)
            )->count();

        $femaleDetainedToday = (clone $baseQuery)

            ->where('gender', 'ښځینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'detention')
                    ->whereDate('created_at', '=', $today)
            )->count();


        //================== Children =========================

        $ChildrenReleasedToday =  (clone $baseQuery)
            ->where('gender', 'ښځینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'release')
                    ->whereDate('created_at', '=', $today)
            )->sum('children_with_mother');

        $ChildrenTransferredToday = (clone $baseQuery)
            ->where('gender', 'ښځینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'multi')
                    ->whereDate('created_at', '=', $today)
            )->sum('children_with_mother');

        $ChildrenDetainedToday = (clone $baseQuery)
            ->where('gender', 'ښځینه')
            ->whereIn(
                'id',
                fn($q) =>
                $q->select('suspect_id')->from('release_suspects')
                    ->where('main_option_key', 'detention')
                    ->whereDate('created_at', '=', $today)
            )->sum('children_with_mother');









        $TotalOfMale = ($newMaleSuspects + $oldMaleSuspects)  - ($maleReleasedToday + $maleTransferredToday + $maleDetainedToday);
        $TotalOfFemale = ($newFemaleSuspects + $oldFemaleSuspects) - ($femaleReleasedToday + $femaleTransferredToday + $femaleDetainedToday);
        $TotalOfChildren = ($newChildrenSuspects + $oldChildrenSuspects) - ($ChildrenReleasedToday + $ChildrenTransferredToday + $ChildrenDetainedToday);

        $GeneralTotalOldSuspects = $oldMaleSuspects + $oldFemaleSuspects + $oldChildrenSuspects;
        $GeneralTotalNewSuspects = $newMaleSuspects + $newFemaleSuspects + $newChildrenSuspects;
        $GeneralTotalReleasedSuspects = $maleReleasedToday + $femaleReleasedToday + $ChildrenReleasedToday;
        $GeneralTotalTransferredSuspects = $maleTransferredToday + $femaleTransferredToday + $ChildrenTransferredToday;
        $GeneralTotalDetainedSuspects = $maleDetainedToday + $femaleDetainedToday + $ChildrenDetainedToday;

        $GrandTotalOfSuspects = $TotalOfMale +   $TotalOfFemale + $TotalOfChildren;

        return PDF::loadView(
            'reports.existing_suspects_summary_pdf',
            compact(
                'oldMaleSuspects',
                'newMaleSuspects',
                'oldFemaleSuspects',
                'newFemaleSuspects',
                'oldChildrenSuspects',
                'newChildrenSuspects',
                'maleReleasedToday',
                'maleTransferredToday',
                'maleDetainedToday',
                'femaleReleasedToday',
                'femaleTransferredToday',
                'femaleDetainedToday',
                'ChildrenReleasedToday',
                'ChildrenTransferredToday',
                'ChildrenDetainedToday',
                'TotalOfMale',
                'TotalOfFemale',
                'TotalOfChildren',
                'GeneralTotalOldSuspects',
                'GeneralTotalNewSuspects',
                'GeneralTotalReleasedSuspects',
                'GeneralTotalTransferredSuspects',
                'GeneralTotalDetainedSuspects',
                'GrandTotalOfSuspects'
            ),
            [],
            ['orientation' => 'L']
        )->stream('Existing_Suspects_Summary.pdf');
    }


    // Released/Transferred Suspects index view
    public function releasedSuspectReport()
    {
        $province = Province::all();
        $releaseSources = ReleaseSource::all();

        $crimeTypes = Suspect::whereNotNull('crime_type')
            ->distinct()
            ->pluck('crime_type');

        return view('reports.released_suspects_report', compact(
            'province',
            'releaseSources',
            'crimeTypes'
        ));
    }


    // Released/Transferred Suspect PDF Report
public function releasedSuspectPdf(Request $request)
{
    $query = Suspect::with([
            'provinceRelation',
            'release.releaseSource'
        ])
        ->whereHas('release');

    // 1️⃣ Gender Filter
    if ($request->filled('gender') && $request->gender !== 'all') {
        $query->where('gender', $request->gender);
    }

    // 2️⃣ Province Filter
    if ($request->filled('province_id')) {
        $query->where('province', $request->province_id);
    }

    // 3️⃣ Crime Type Filter
    if ($request->filled('crime_type')) {
        $query->where('crime_type', $request->crime_type);
    }

    // 4️⃣ Release Source Filter
    if ($request->filled('release_source_id')) {
        $query->whereHas('release', function ($q) use ($request) {
            $q->where('release_source_id', $request->release_source_id);
        });
    }

    // 5️⃣ Date Range Filter
 if ($request->filled('start_date') && $request->filled('end_date')) {

    $start = $this->to_esawi_date($request->start_date);
    $end   = $this->to_esawi_date($request->end_date);

    $query->whereHas('release', function ($q) use ($start, $end) {
        $q->whereBetween('release_date', [$start, $end]);
    });
}


    $suspects = $query->orderByDesc('created_at')->get();

    return PDF::loadView(
        'reports.released_suspects_pdf',
        compact('suspects'),
        [],
        ['orientation' => 'L']
    )->stream('Released_Suspects_Report.pdf');
}




    //=================================================================
    // Monthly Suspect PDF Report
    public function monthlySuspectPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d',
        ]);

        $startJalali = $request->start_date;
        $endJalali = $request->end_date;

        $suspects = [];
        $sumMale = 0;
        $sumFemale = 0;
        $sumChildren = 0;
        $sumGrand = 0;
        $dayNo = 1;

        //split year and month for report title
        $jalali = Jalalian::fromFormat('Y-m-d', $request->start_date);

        $afghanMonths = [
            1  => 'حمل',
            2  => 'ثور',
            3  => 'جوزا',
            4  => 'سرطان',
            5  => 'اسد',
            6  => 'سنبله',
            7  => 'میزان',
            8  => 'عقرب',
            9  => 'قوس',
            10 => 'جدی',
            11 => 'دلو',
            12 => 'حوت',
        ];

        $monthNumber = (int) $jalali->format('m');

        $reportMonth = $afghanMonths[$monthNumber];
        $reportYear  = $jalali->format('Y');



        // Convert start and end Jalali to Carbon for looping
        $startDate = Jalalian::fromFormat('Y-m-d', $startJalali)->toCarbon()->startOfDay();
        $endDate = Jalalian::fromFormat('Y-m-d', $endJalali)->toCarbon()->startOfDay();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

            // Convert current Gregorian date back to check in DB
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            // Query only for this exact day
            $maleCount = Suspect::where('gender', 'نارینه')
                ->where('status', 'prisoner')
                ->whereDate('monitoring_date', '>=', $dayStart)
                ->whereDate('monitoring_date', '<=', $dayEnd)
                ->count();

            $femaleCount = Suspect::where('gender', 'ښځینه')
                ->where('status', 'prisoner')
                ->whereDate('monitoring_date', '>=', $dayStart)
                ->whereDate('monitoring_date', '<=', $dayEnd)
                ->count();

            $childrenCount = Suspect::where('gender', 'ښځینه')
                ->where('status', 'prisoner')
                ->whereDate('monitoring_date', '>=', $dayStart)
                ->whereDate('monitoring_date', '<=', $dayEnd)
                ->sum('children_with_mother');

            $grandTotal = $maleCount + $femaleCount + $childrenCount;

            $sumMale += $maleCount;
            $sumFemale += $femaleCount;
            $sumChildren += $childrenCount;
            $sumGrand += $grandTotal;

            $suspects[] = [
                'day'      => $dayNo,
                'male'     => $maleCount,
                'female'   => $femaleCount,
                'children' => $childrenCount,
                'total'    => $grandTotal,
            ];

            $dayNo++;
        }

        return PDF::loadView(
            'reports.monthly_suspects_pdf',
            compact(
                'suspects',
                'sumMale',
                'sumFemale',
                'sumChildren',
                'sumGrand',
                'reportMonth',
                'reportYear'
            )
        )->stream('Monthly_Suspects_Report.pdf');
    }
}
