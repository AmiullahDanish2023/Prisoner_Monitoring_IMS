<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suspect;
use App\Models\Province;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function generalReport()
    {
        $province = Province::all();
        return view('reports.general_report', compact('province'));
    }

    public function createGeneralReport(Request $request)
    {
        // Optional dates
        $start = null;
        $end   = null;

        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
        }

        // Main query
        $suspects = Suspect::leftJoin('release_suspects', 'suspects.id', '=', 'release_suspects.suspect_id')
            ->join('provinces', 'suspects.province', '=', 'provinces.id')
            ->whereNull('release_suspects.suspect_id') // hide released suspects
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
            ->get();

        // Province model (nullable)
        $province = null;
        if ($request->province_id) {
            $province = Province::find($request->province_id);
        }

        // Generate PDF
        $pdf = PDF::loadView(
            'reports.general_report_pdf',
            compact('suspects', 'province', 'start', 'end')
        )
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'bahijfont')
            ->setOption('fontCache', storage_path('fonts'))
            ->setOption('tempDir', storage_path('fonts'));

        return $pdf->stream('General_Suspects_Report.pdf');
    }
}
