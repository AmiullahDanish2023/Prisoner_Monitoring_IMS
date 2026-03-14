<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Suspect;
use App\Models\ReleaseSource;
use App\Models\ReleaseSuspect;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;
use App\Models\SuspectFile;

class ReleaseController extends Controller
{

    public function to_esawi_date($date)
    {
        return Jalalian::fromFormat('Y-m-d', $date)->toCarbon();
    }

    public function to_dari_date($date)
    {
        return CalendarUtils::strftime('Y-m-d', strtotime($date));
    }
    // -------------------------
    // Load Release Page
    // -------------------------
    public function releaseSuspect()
    {
        $province = Province::all();

        return view('suspects.releaseSuspect', compact('province'));
    }

    // Show Released / Transferred Suspects List

    public function show()
    {
        $data = ReleaseSuspect::join('suspects', 'release_suspects.suspect_id', '=', 'suspects.id')
            ->leftJoin('provinces', 'suspects.province', '=', 'provinces.id')
            ->select(
                'suspects.*',
                'release_suspects.issued_or_transferred_number',
                'release_suspects.main_option_key',
                'release_suspects.db_source_name',
                'release_suspects.release_date',
                'release_suspects.file',
                'provinces.name_da as province_name'
            )
            ->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = "<div class='action-buttons'>";

                // View Button
                if (auth()->user()->can('View Release or Transfer Suspect Details')) {
                    $btn .= "<a href='" . route('release_details', $row->id) . "' 
                        class='view-btn btn btn-outline-primary btn-sm' data-title='مشاهده جزئیات'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' 
                            stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <circle cx='12' cy='12' r='3'/>
                            <path d='M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z'/>
                        </svg>
                    </a>";
                }

                // Delete Button
                if (auth()->user()->can('Delete Release or Transfer Suspect')) {
                    $btn .= "<a class='release_destroy_btn btn btn-sm btn-outline-danger' 
                        data-id='{$row->id}' data-title='حذف ریکارډ'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none'
                            stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <polyline points='3 6 5 6 21 6'/>
                            <path d='M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6'/>
                            <path d='M10 11v6'/>
                            <path d='M14 11v6'/>
                            <path d='M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2'/>
                        </svg>
                    </a>";
                }

                return $btn;
            })
            ->addColumn('release_date', function ($row) {
                return $this->to_dari_date($row->release_date);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function details($id)
    {
        $release = ReleaseSuspect::all();
        $suspect = Suspect::with(['provinceRelation', 'release','releaseFiles'])
            ->findOrFail($id);

        if (!empty($suspect->monitoring_date)) {
            $suspect->monitoring_date = $this->to_dari_date($suspect->monitoring_date);
        }
        if (!empty($suspect->release->release_date)) {
            $suspect->release->release_date = $this->to_dari_date($suspect->release->release_date);
        }


        return view('suspects.releaseDetails', compact('suspect'));
    }


    // Delete release suspect
    public function destroy($id)
    {
        $suspect = Suspect::findOrFail($id);
        $suspect->delete();
        return response()->json(['status' => true, 'message' => 'ریکارډ حذف شو']);
    }

    public function release(Request $request)
    {

        $request->validate([
            'suspect_id'   => 'required|exists:suspects,id',
            'issued_or_transferred_number'  => 'required',
            'main_option_key' => 'required',
            'release_date' => 'required',
        ]);

        $release = new ReleaseSuspect();

        $release->suspect_id = $request->suspect_id;
        $release->issued_or_transferred_number = $request->issued_or_transferred_number;
        $release->main_option_key = $request->main_option_key;
        $release->db_source_name = $request->db_source_name;
        $release->release_date = $this->to_esawi_date($request->release_date);

        $release->save();

        // update suspect status
        $suspect = Suspect::find($request->suspect_id);
        $suspect->status = 'released';
        $suspect->save();


        if ($request->hasFile('file')) {

            foreach ($request->file('file') as $file) {

                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads/releases'), $filename);

                SuspectFile::create([
                    'suspect_id' => $request->suspect_id,
                    'file_path' => 'uploads/releases/' . $filename,
                    'file_type' => 'release',
                ]);
            }
        }
       

        return response()->json([
            'status'  => true,
            'message' => 'مظنون په بریالیتوب سره رها / انتقال شو.'
        ]);
    }
}
