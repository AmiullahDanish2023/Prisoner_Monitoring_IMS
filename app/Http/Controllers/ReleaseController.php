<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Suspect;
use App\Models\ReleaseSource;
use App\Models\ReleaseSuspect;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
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
                $btn .= "<a href='" . route('release_details', $row->id) . "' 
                        class='view-btn btn btn-outline-primary btn-sm' data-title='مشاهده جزئیات'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' 
                            stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <circle cx='12' cy='12' r='3'/>
                            <path d='M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z'/>
                        </svg>
                    </a>";

                // Delete Button
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

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function details($id)
    {
        $suspect = Suspect::with(['provinceRelation', 'release'])
            ->findOrFail($id);

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
            'main_option_key' => 'required',     // required
            'release_date' => 'required'
        ]);

        $release = new ReleaseSuspect();
        $release->suspect_id = $request->suspect_id;
        $release->issued_or_transferred_number = $request->issued_or_transferred_number;

        // NEW FIELDS
        $release->main_option_key = $request->main_option_key;
        $release->db_source_name = $request->db_source_name; // nullable

        $release->release_date = $request->release_date;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/releases'), $filename);
            $release->file = 'uploads/releases/' . $filename;
        }

        $release->save();

        return response()->json([
            'status'  => true,
            'message' => 'مظنون په بریالیتوب سره رها / انتقال شو.'
        ]);
    }
}
