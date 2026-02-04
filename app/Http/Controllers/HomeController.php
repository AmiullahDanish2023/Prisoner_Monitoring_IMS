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

        // Active prisoners (not released)
        $totalPrisoners = Suspect::where('status', 'prisoner')->count();

        $maleCount = Suspect::where('status', 'prisoner')
            ->where('gender', 'نارینه')->count();

        $femaleCount = Suspect::where('status', 'prisoner')
            ->where('gender', 'ښځینه')->count();

        $childrenCount = Suspect::where('status', 'prisoner')
            ->sum('children_with_mother');

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
            'livelihoodTotals'
        ));
    }
}
