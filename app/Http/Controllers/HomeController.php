<?php

namespace App\Http\Controllers;

use App\Models\Suspect;
use App\Models\Livelihood;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /* ================= KPI CARDS ================= */

        $data = Suspect::where('status', 'prisoner')
            ->selectRaw("
        COUNT(*) as totalPrisoners,
        SUM(CASE WHEN gender = 'نارینه' THEN 1 ELSE 0 END) as maleCount,
        SUM(CASE WHEN gender = 'ښځینه' THEN 1 ELSE 0 END) as femaleCount,
        SUM(COALESCE(children_with_mother, 0)) as childrenCount
    ")
            ->first();

        $totalPrisoners   = $data->totalPrisoners;
        $maleCount        = $data->maleCount;
        $femaleCount      = $data->femaleCount;
        $childrenCount    = $data->childrenCount;
        $totalWithChildren = $totalPrisoners + $childrenCount;

        /* ================= STATUS BAR ================= */

        $releasedCount = Suspect::where('status', 'released')->count();
        $detainedCount = Suspect::where('status', 'prisoner')->count();

        /* ================= GENDER DONUT ================= */

        $genderChart = [
            $maleCount,
            $femaleCount,
            $childrenCount
        ];

        /* ================= LIVELIHOOD LINE ================= */

        $livelihoodData = Livelihood::select(
            DB::raw('DATE(livelihoodDate) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        $livelihoodLabels = $livelihoodData->pluck('date');
        $livelihoodTotals = $livelihoodData->pluck('total');

        return view('home', compact(
            'totalPrisoners',
            'maleCount',
            'femaleCount',
            'childrenCount',
            'releasedCount',
            'detainedCount',
            'genderChart',
            'livelihoodLabels',
            'livelihoodTotals',
            'totalWithChildren'
        ));
    }
}
