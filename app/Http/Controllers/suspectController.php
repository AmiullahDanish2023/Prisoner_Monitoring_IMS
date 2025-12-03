<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\suspect;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class suspectController extends Controller
{
  public function index()
  {
    $province = Province::all();
    return view('suspects.index', compact('province'));
  }
  public function show()
  {
    $data = suspect::join('provinces', 'suspects.province', '=', 'provinces.id')
      ->select('suspects.*', 'provinces.name_da as province_name')
      ->get();

    return datatables()->of($data)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        // Wrap all buttons in a flex container for proper spacing
        $btn = "<div class='action-buttons'>";

        // View Button
        $btn .= "<a href='" . route('details', $row->id) . "' class='view-btn btn btn-outline-primary btn-sm' data-title='مشاهده جزئیات' style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <circle cx='12' cy='12' r='3'/>
                            <path d='M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z'/>
                        </svg>
                    </a>";

        // Edit Button
        $btn .= "<a class='edit-btn btn btn-outline-info btn-sm' data-title='د معلوماتو تغیرول' style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;' data-id='" . $row->id . "'>
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
                            <path d='M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2'/>
                        </svg>
                    </a>";

        // Release Button
        $btn .= "<a class='release-btn btn btn-sm btn-outline-success' data-title='مظنون خلاصول' data-id='{$row->id}' style='cursor:pointer; display:inline-flex; align-items:center; gap:6px;'>
            <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                <rect x='3' y='11' width='18' height='11' rx='2'/>
                <path d='M7 11V7a5 5 0 0 1 10-3'/>
            </svg>
        </a>";



        return $btn;
      })
      ->escapeColumns([])
      ->rawColumns(['action'])
      ->make(true);
  }



  public function store(Request $request)
  {
    $validator = validator::make($request->all(), [
      // 'gender' => 'required',
      'suspect_name' => 'required',
      'father_name' => 'required',
      'grandfather_name' => 'required',
      'crime_type' => 'required',
      'referring_authority' => 'required',
      'monitoring_date' => 'required|date',
      'province' => 'required',
      'district' => 'required',
      'area' => 'required',
      'file' => 'nullable|file',
    ]);

    if ($validator->fails()) {
      return json_encode($validator->errors()->toArray());
    }

    $suspectStore = new suspect();
    $suspectStore->gender = $request->gender;
    $suspectStore->suspect_name = $request->suspect_name;
    $suspectStore->father_name = $request->father_name;
    $suspectStore->grandfather_name = $request->grandfather_name;
    $suspectStore->children_with_mother = $request->children_with_mother;
    $suspectStore->crime_type = $request->crime_type;
    $suspectStore->referring_authority = $request->referring_authority;
    $suspectStore->monitoring_date = $request->monitoring_date;
    $suspectStore->province = $request->province;
    $suspectStore->district = $request->district;
    $suspectStore->area = $request->area;

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads/files'), $filename);
      $suspectStore->file = 'uploads/files/' . $filename;
    }

    $suspectStore->save();

    return response()->json(['status' => true, 'message' => ' معلومات په بریالیتوب سره ثبت شول!']);
  }

  public function edit($id)
  {
    $suspect = Suspect::join('provinces', 'suspects.province', '=', 'provinces.id')
      ->select('suspects.*', 'provinces.id as province_id', 'provinces.name_da as province_name')
      ->where('suspects.id', $id)
      ->first();

    return response()->json($suspect);
  }


  public function update(Request $request, $id)
  {
    $suspect = Suspect::findOrFail($id);

    $request->validate([
      // 'gender' => 'required',
      'suspect_name' => 'required',
      'father_name' => 'required',
      'grandfather_name' => 'required',
      // 'children_with_mother' => 'required',
      'crime_type' => 'required',
      'referring_authority' => 'required',
      'monitoring_date' => 'required|date',
      'province' => 'required',
      'district' => 'required',
      'area' => 'required',
      'file' => 'nullable|file',
    ]);


    $suspect->gender = $request->gender;
    $suspect->suspect_name = $request->suspect_name;
    $suspect->father_name = $request->father_name;
    $suspect->grandfather_name = $request->grandfather_name;
    $suspect->children_with_mother = $request->children_with_mother;
    $suspect->crime_type = $request->crime_type;
    $suspect->referring_authority = $request->referring_authority;
    $suspect->monitoring_date = $request->monitoring_date;
    $suspect->province = $request->province;
    $suspect->district = $request->district;
    $suspect->area = $request->area;

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads/files'), $filename);
      $suspect->file = 'uploads/files/' . $filename;
    }

    $suspect->save();

    return response()->json([
      'status' => true,
      'message' => 'معلومات په بریالیتوب سره تغیر شول!'
    ]);
  }


  // Delete suspect
  public function destroy($id)
  {
    $suspect = Suspect::findOrFail($id);
    $suspect->delete();
    return response()->json(['status' => true, 'message' => 'ریکارډ حذف شو']);
  }

  public function details($id)
  {

    $suspect = Suspect::with(['provinceRelation'])->findOrFail($id);

    return view('suspects.details', compact('suspect'));
  }

  public function release(Request $request)
  {
    $request->validate([
      'suspect_id'   => 'required|exists:suspects,id',
      'released_by'  => 'required',
      'release_date' => 'required|date',
      'release_type' => 'nullable|string'
    ]);

    $suspect = Suspect::find($request->suspect_id);

    // Save release information
    $suspect->release_type   = $request->release_type;
    $suspect->released_by    = $request->released_by;
    $suspect->release_date   = $request->release_date;
  
    $suspect->save();

    return response()->json([
      'status'  => true,
      'message' => 'مظنون په بریالیتوب سره رها / انتقال شو.'
    ]);
  }
}
