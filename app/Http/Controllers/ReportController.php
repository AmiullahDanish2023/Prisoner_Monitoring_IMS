<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suspect;
use App\Models\ReleaseSuspect;
use App\Models\Province;
use App\Models\ReleaseSource;
use App\Models\SuspectFile;
use PDF;
use Illuminate\Support\Facades\DB;
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
        $referrer = Suspect::whereNotNull('referring_authority')
            ->where('status', 'prisoner')
            ->distinct()
            ->orderBy('referring_authority')
            ->pluck('referring_authority');

        return view('reports.general_report', compact('province', 'referrer'));
    }


    public function createGeneralReport(Request $request)
    {
        $start = null;
        $end   = null;

        if ($request->start_date && $request->end_date) {

            $start = Jalalian::fromFormat('Y-m-d', $request->start_date)
                ->toCarbon()
                ->startOfDay();

            $end = Jalalian::fromFormat('Y-m-d', $request->end_date)
                ->toCarbon()
                ->endOfDay();
        }
        $suspects = Suspect::leftJoin('release_suspects', 'suspects.id', '=', 'release_suspects.suspect_id')
            ->join('provinces', 'suspects.province', '=', 'provinces.id')
            ->whereNull('release_suspects.suspect_id')
            ->where('suspects.status', 'prisoner')
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
            ->when($request->referrer, function ($query) use ($request) {
                $query->where('suspects.referring_authority', $request->referrer);
            })
            ->get();
        $selectedReferrer = $request->referrer;

        $province = null;
        if ($request->province_id) {
            $province = Province::find($request->province_id);
        }

        $pdf = PDF::loadView(
            'reports.general_report_pdf',
            compact('suspects', 'province', 'start', 'end', 'selectedReferrer'),
            [],
            ['orientation' => 'L']
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
            ->where('status', 'prisoner')
            ->where('gender', 'نارینه')
            ->count();


        $newMaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '=', $today)
            ->where('status', 'prisoner')
            ->where('gender', 'نارینه')
            ->count();

        $oldFemaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '<', $today)
            ->where('status', 'prisoner')
            ->where('gender', 'ښځینه')
            ->count();


        $newFemaleSuspects = (clone $baseQuery)
            ->whereDate('created_at', '=', $today)
            ->where('status', 'prisoner')
            ->where('gender', 'ښځینه')
            ->count();

        $oldChildrenSuspects = (clone $baseQuery)
            ->whereDate('created_at', '<', $today)
            ->where('status', 'prisoner')
            ->sum('children_with_mother');


        $newChildrenSuspects = (clone $baseQuery)
            ->whereDate('created_at', '=', $today)
            ->where('status', 'prisoner')
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


    public function releasedSuspectPdf(Request $request)
    {
        // ================= FILE REPORT =================
        if ($request->filled('file_filter')) {

            $query = SuspectFile::with([
                'suspect' => function ($q) {
                    $q->with(['provinceRelation', 'release.releaseSource']);
                }
            ]);

            // File Type Filter
            if ($request->file_filter == 'suspect') {
                $query->where('file_type', 'suspect');
            }

            if ($request->file_filter == 'release') {
                $query->where('file_type', 'release')
                    ->whereHas('suspect', function ($q) {
                        $q->where('status', 'released');
                    });
            }

            if ($request->file_filter == 'all') {
                $query->where(function ($q) {

                    $q->where('file_type', 'suspect')

                        ->orWhere(function ($subQ) {
                            $subQ->where('file_type', 'release')
                                ->whereHas('suspect', function ($sq) {
                                    $sq->where('status', 'released');
                                });
                        });
                });
            }

            // Apply suspect-related filters for ALL file types
            $query->whereHas('suspect', function ($q) use ($request) {

                // Gender
                if ($request->filled('gender') && $request->gender !== 'all') {
                    $q->where('gender', $request->gender);
                }

                // Province
                if ($request->filled('province_id')) {
                    $q->where('province', $request->province_id);
                }

                // Crime
                if ($request->filled('crime_type')) {
                    $q->where('crime_type', $request->crime_type);
                }

                // Suspect Name
                if ($request->filled('first_name')) {
                    $q->where('suspect_name', 'like', '%' . $request->first_name . '%');
                }

                // Father Name
                if ($request->filled('father_name')) {
                    $q->where('father_name', 'like', '%' . $request->father_name . '%');
                }

                // Release Filters on suspect's release (only for released suspects)
                if (
                    $request->filled('main_option_key') ||
                    $request->filled('db_source_name') ||
                    ($request->filled('start_date') && $request->filled('end_date'))
                ) {

                    $q->whereHas('release', function ($r) use ($request) {

                        if ($request->filled('main_option_key')) {
                            $r->where('main_option_key', $request->main_option_key);
                        }

                        if ($request->filled('db_source_name')) {
                            $r->where('db_source_name', $request->db_source_name);
                        }

                        if ($request->filled('start_date') && $request->filled('end_date')) {
                            $start = $this->to_esawi_date($request->start_date);
                            $end   = $this->to_esawi_date($request->end_date);
                            $r->whereBetween('release_date', [$start, $end]);
                        }
                    });
                }
            });

            $files = $query->latest()->get();

            // Debug: Check file count
            // dd([
            //     'file_filter' => $request->file_filter,
            //     'total_files' => $files->count(),
            //     'suspect_files' => $files->where('file_type', 'suspect')->count(),
            //     'release_files' => $files->where('file_type', 'release')->count(),
            //     'sql' => $query->toSql(),
            //     'bindings' => $query->getBindings()
            // ]);

            // Check if files are empty
            if ($files->isEmpty()) {
                return back()->with('error', 'هیڅ فایل ونه موندل شو!');
            }

            return PDF::loadView(
                'reports.files_report_pdf',
                compact('files'),
                [],
                ['orientation' => 'portrait']
            )->stream('Files_Report.pdf');
        }

        // ================= RELEASED SUSPECT REPORT =================
        
        $query = Suspect::with([
            'provinceRelation',
            'release.releaseSource'
        ])->where('status', 'released');

        // Gender
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // Province
        if ($request->filled('province_id')) {
            $query->where('province', $request->province_id);
        }

        // Crime
        if ($request->filled('crime_type')) {
            $query->where('crime_type', $request->crime_type);
        }

        // Suspect Name
        if ($request->filled('first_name')) {
            $query->where('suspect_name', 'like', '%' . $request->first_name . '%');
        }

        // Father Name
        if ($request->filled('father_name')) {
            $query->where('father_name', 'like', '%' . $request->father_name . '%');
        }

        // Release Filters
        if (
            $request->filled('main_option_key') ||
            $request->filled('db_source_name') ||
            ($request->filled('start_date') && $request->filled('end_date'))
        ) {

            $query->whereHas('release', function ($q) use ($request) {

                if ($request->filled('main_option_key')) {
                    $q->where('main_option_key', $request->main_option_key);
                }

                if ($request->filled('db_source_name')) {
                    $q->where('db_source_name', $request->db_source_name);
                }

                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $start = $this->to_esawi_date($request->start_date);
                    $end   = $this->to_esawi_date($request->end_date);
                    $q->whereBetween('release_date', [$start, $end]);
                }
            });
        }

        $suspects = $query->orderByDesc('created_at')->get();

        if ($suspects->isEmpty()) {
            return back()->with('error', 'هیڅ مظنون ونه موندل شو!');
        }

        return PDF::loadView(
            'reports.released_suspects_pdf',
            compact('suspects'),
            [],
            ['orientation' => 'L']
        )->stream('Released_Suspects_Report.pdf');
    }


    public function monthlySuspectReport()
    {
        return view('reports.monthly_suspects_report');
    }




    //=================================================================
    // Monthly Suspect PDF Report

    public function monthlySuspectPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date'   => 'required'
        ]);

        $startJalali = $request->start_date;
        $endJalali = $request->end_date;

        $suspects = [];
        $sumMale = 0;
        $sumFemale = 0;
        $sumChildren = 0;
        $sumGrand = 0;
        $dayNo = 1;

        // Split year and month for report title
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

        // Get all dates that have events (registrations or releases)
        $eventDates = [];

        // Get dates with registrations
        $registrationDates = Suspect::where('status', 'prisoner')
            ->whereDate('monitoring_date', '>=', $startDate)
            ->whereDate('monitoring_date', '<=', $endDate)
            ->select('monitoring_date')
            ->distinct()
            ->pluck('monitoring_date')
            ->toArray();

        // Get dates with releases
        $releaseDates = DB::table('release_suspects')
            ->where('release_date', '>=', $startDate->format('Y-m-d'))
            ->where('release_date', '<=', $endDate->format('Y-m-d'))
            ->whereNotNull('release_date')
            ->where('release_date', '!=', '')
            ->select('release_date')
            ->distinct()
            ->pluck('release_date')
            ->toArray();

        // Merge all event dates
        $eventDates = array_unique(array_merge($registrationDates, $releaseDates));
        sort($eventDates);

        // Initialize current existing counts (before start date)
        $registeredBeforeStartMale = Suspect::where('gender', 'نارینه')
            ->where('status', 'prisoner')
            ->whereDate('monitoring_date', '<', $startDate)
            ->count();

        $registeredBeforeStartFemale = Suspect::where('gender', 'ښځینه')
            ->where('status', 'prisoner')
            ->whereDate('monitoring_date', '<', $startDate)
            ->count();

        $registeredBeforeStartChildren = Suspect::where('gender', 'ښځینه')
            ->where('status', 'prisoner')
            ->whereDate('monitoring_date', '<', $startDate)
            ->sum('children_with_mother');

        // Get released suspects before start date
        $releasedBeforeStartMale = DB::table('release_suspects')
            ->join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
            ->where('suspects.gender', 'نارینه')
            ->where('release_suspects.release_date', '<', $startDate->format('Y-m-d'))
            ->whereNotNull('release_suspects.release_date')
            ->where('release_suspects.release_date', '!=', '')
            ->count();

        $releasedBeforeStartFemale = DB::table('release_suspects')
            ->join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
            ->where('suspects.gender', 'ښځینه')
            ->where('release_suspects.release_date', '<', $startDate->format('Y-m-d'))
            ->whereNotNull('release_suspects.release_date')
            ->where('release_suspects.release_date', '!=', '')
            ->count();

        $releasedBeforeStartChildren = DB::table('release_suspects')
            ->join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
            ->where('suspects.gender', 'ښځینه')
            ->where('release_suspects.release_date', '<', $startDate->format('Y-m-d'))
            ->whereNotNull('release_suspects.release_date')
            ->where('release_suspects.release_date', '!=', '')
            ->sum('suspects.children_with_mother');

        // Current existing before loop starts
        $currentMale = $registeredBeforeStartMale + $releasedBeforeStartMale;
        $currentFemale = $registeredBeforeStartFemale + $releasedBeforeStartFemale;
        $currentChildren = $registeredBeforeStartChildren + $releasedBeforeStartChildren;

        $grandTotal = $currentMale + $currentFemale + $currentChildren;

        // Initialize event day counter
        $eventDayCount = 0;

        // If no events exist, show initial state
        if (empty($eventDates)) {
            $eventDayCount = 1;
            $suspects[] = [
                'day'      => $eventDayCount,
                'male'     => $currentMale,
                'female'   => $currentFemale,
                'children' => $currentChildren,
                'total'    => $grandTotal,
            ];

            $sumMale = $currentMale;
            $sumFemale = $currentFemale;
            $sumChildren = $currentChildren;
            $sumGrand = $grandTotal;
        } else {
            // Initialize sums for cumulative totals - start with 0
            $sumMale = 0;
            $sumFemale = 0;
            $sumChildren = 0;
            $sumGrand = 0;

            // Process each event date
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $dayStart = $date->copy()->startOfDay();
                $dayEnd = $date->copy()->endOfDay();
                $currentDateString = $date->format('Y-m-d');

                // Check if current date has any events
                $hasEvents = in_array($currentDateString, $eventDates) ||
                    in_array($date->format('Y-m-d'), $eventDates);

                if ($hasEvents) {
                    // Today's new registrations
                    $todayMaleRegistered = Suspect::where('gender', 'نارینه')
                        ->where('status', 'prisoner')
                        ->whereDate('monitoring_date', '>=', $dayStart)
                        ->whereDate('monitoring_date', '<=', $dayEnd)
                        ->count();

                    $todayFemaleRegistered = Suspect::where('gender', 'ښځینه')
                        ->where('status', 'prisoner')
                        ->whereDate('monitoring_date', '>=', $dayStart)
                        ->whereDate('monitoring_date', '<=', $dayEnd)
                        ->count();

                    $todayChildrenRegistered = Suspect::where('gender', 'ښځینه')
                        ->where('status', 'prisoner')
                        ->whereDate('monitoring_date', '>=', $dayStart)
                        ->whereDate('monitoring_date', '<=', $dayEnd)
                        ->sum('children_with_mother');

                    // Today's releases from release_suspects table
                    $todayMaleReleased = DB::table('release_suspects')
                        ->join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
                        ->where('suspects.gender', 'نارینه')
                        ->where('release_suspects.release_date', $currentDateString)
                        ->count();

                    $todayFemaleReleased = DB::table('release_suspects')
                        ->join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
                        ->where('suspects.gender', 'ښځینه')
                        ->where('release_suspects.release_date', $currentDateString)
                        ->count();

                    $todayChildrenReleased = DB::table('release_suspects')
                        ->join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
                        ->where('suspects.gender', 'ښځینه')
                        ->where('release_suspects.release_date', $currentDateString)
                        ->sum('suspects.children_with_mother');

                    // Apply formula: Current Existing = Previous Existing + Today Entry - Today Release
                    $currentMale = $currentMale + $todayMaleRegistered - $todayMaleReleased;
                    $currentFemale = $currentFemale + $todayFemaleRegistered - $todayFemaleReleased;
                    $currentChildren = $currentChildren + $todayChildrenRegistered - $todayChildrenReleased;

                    $grandTotal = $currentMale + $currentFemale + $currentChildren;

                    $eventDayCount++;

                    $suspects[] = [
                        'day'      => $eventDayCount,
                        'male'     => $currentMale,
                        'female'   => $currentFemale,
                        'children' => $currentChildren,
                        'total'    => $grandTotal,
                    ];

                    // Add current day's values to cumulative sums
                    $sumMale += $currentMale;
                    $sumFemale += $currentFemale;
                    $sumChildren += $currentChildren;
                    $sumGrand += $grandTotal;
                }

                $dayNo++;
            }
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
//Current Existing=Previous Existing+Today Entry−Today Release