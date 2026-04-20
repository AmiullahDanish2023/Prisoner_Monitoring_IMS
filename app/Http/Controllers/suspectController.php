<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\suspect;
use App\Models\ReleaseSource;
use App\Models\SuspectFile;
use App\Models\ReleaseSuspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;
use PDF;


class suspectController extends Controller
{
  public function to_esawi_date($date)
  {
    return Jalalian::fromFormat('Y-m-d', $date)->toCarbon();
  }

  public function to_dari_date($date)
  {
    return CalendarUtils::strftime('Y-m-d', strtotime($date));
  }

  public function index()
  {

    $province = Province::all();
    $releaseOptions = ReleaseSource::all();
    return view('suspects.index', compact('province', 'releaseOptions'));
  }
  public function show()
  {
    $data = Suspect::leftJoin('release_suspects', 'suspects.id', '=', 'release_suspects.suspect_id')
      ->join('provinces', 'suspects.province', '=', 'provinces.id')
      ->whereNull('release_suspects.suspect_id')   // ✔ hide released suspects
      ->select('suspects.*', 'provinces.name_da as province_name')
      ->get();


    return datatables()->of($data)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        // Wrap all buttons in a flex container for proper spacing
        $btn = "<div class='action-buttons'>";

        // View Button
        if (auth()->user()->can('View Suspect Details')) {
          $btn .= "<a href='" . route('details', $row->id) . "' class='view-btn btn btn-outline-primary btn-sm' data-title='مشاهده جزئیات' style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <circle cx='12' cy='12' r='3'/>
                            <path d='M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z'/>
                        </svg>
                    </a>";
        }

        // Edit Button
        if (auth()->user()->can('Edit Suspect')) {
          $btn .= "<a class='edit-btn btn btn-outline-info btn-sm' data-title='د معلوماتو تغیرول' style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;' data-id='" . $row->id . "'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <path d='M12 20h9'/>
                            <path d='M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z'/>
                        </svg>
                    </a>";
        }

        // // Delete Button
        // if (auth()->user()->can('Delete Suspect')) {
        //   $btn .= "<a class='destroy_btn btn btn-sm btn-outline-danger' data-title='د ریکارډ حذفول' style='cursor: pointer; display:inline-flex; align-items:center; gap:6px;' data-id='" . $row->id . "'>
        //                 <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
        //                     <polyline points='3 6 5 6 21 6'/>
        //                     <path d='M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6'/>
        //                     <path d='M10 11v6'/>
        //                     <path d='M14 11v6'/>
        //                     <path d='M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2'/>
        //                 </svg>
        //             </a>";
        // }

        // Release Button
        if (auth()->user()->can('Release Suspect')) {
          $btn .= "<a class='release-btn btn btn-sm btn-outline-success' data-title='مظنون خلاصول' data-id='{$row->id}'  style='cursor:pointer; display:inline-flex; align-items:center; gap:6px;'>
            <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                <rect x='3' y='11' width='18' height='11' rx='2'/>
                <path d='M7 11V7a5 5 0 0 1 10-3'/>
            </svg>
         </a>";
        }


        return $btn;
      })
      ->addColumn('monitoring_date', function ($row) {
        return $this->to_dari_date($row->monitoring_date);
      })
      ->escapeColumns([])
      ->rawColumns(['action'])
      ->make(true);
  }

  public function store(Request $request)
  {
    $validator = validator::make($request->all(), [
      'gender' => 'required',
      'suspect_name' => 'required',
      'father_name' => 'required',
      'children_with_mother' => 'nullable|string',
      'grandfather_name' => 'required',
      'crime_type' => 'required',
      'referring_authority' => 'required',
      'monitoring_date' => 'required|date',
      'province' => 'required',
      'district' => 'required',
      'area' => 'required',
      'file' => 'nullable|array',
      'file.*' => 'file|max:5120 ,mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx|max:20480',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $suspectStore = new suspect();
    $suspectStore->gender = $request->gender;
    $suspectStore->suspect_name = $request->suspect_name;
    $suspectStore->father_name = $request->father_name;
    $suspectStore->grandfather_name = $request->grandfather_name;
    $suspectStore->children_with_mother = $request->children_with_mother;
    $suspectStore->crime_type = $request->crime_type;
    $suspectStore->referring_authority = $request->referring_authority;
    $suspectStore->monitoring_date = $this->to_esawi_date($request->monitoring_date);
    $suspectStore->province = $request->province;
    $suspectStore->district = $request->district;
    $suspectStore->area = $request->area;
    $suspectStore->has_items = $request->has_items ?? null;
    $suspectStore->save();

    if ($request->hasFile('file')) {

      foreach ($request->file('file') as $file) {

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/files'), $filename);

        $suspectStore->files()->create([
          'file_path' => 'uploads/files/' . $filename,
          'file_type' => 'suspect',
        ]);
      }
    }


    return response()->json([
      'status' => true,
      'message' => 'معلومات په بریالیتوب سره ثبت شول!'
    ]);
  }

  public function edit($id)
  {
    $suspect = Suspect::with('files')
      ->join('provinces', 'suspects.province', '=', 'provinces.id')
      ->select('suspects.*', 'provinces.id as province_id', 'provinces.name_da as province_name')
      ->where('suspects.id', $id)
      ->first();

    if (!empty($suspect->monitoring_date)) {
      $suspect->monitoring_date = $this->to_dari_date($suspect->monitoring_date);
    }

    $suspect->has_items = $suspect->has_items === null
      ? null
      : ($suspect->has_items ? 1 : 0);

    return response()->json($suspect);
  }


  public function update(Request $request, $id)
  {
    $suspect = Suspect::findOrFail($id);

    $request->validate([
      'suspect_name' => 'required',
      'father_name' => 'required',
      'grandfather_name' => 'required',
      'crime_type' => 'required',
      'referring_authority' => 'required',
      'monitoring_date' => 'required|date',
      'province' => 'required',
      'district' => 'required',
      'area' => 'required',
    ]);

    $suspect->gender = $request->gender;
    $suspect->suspect_name = $request->suspect_name;
    $suspect->father_name = $request->father_name;
    $suspect->grandfather_name = $request->grandfather_name;
    $suspect->children_with_mother = $request->children_with_mother;
    $suspect->crime_type = $request->crime_type;
    $suspect->referring_authority = $request->referring_authority;
    $suspect->monitoring_date = $this->to_esawi_date($request->monitoring_date);
    $suspect->province = $request->province;
    $suspect->district = $request->district;
    $suspect->area = $request->area;
    $suspect->has_items = $request->filled('has_items') ? (int) $request->has_items : null;

    $suspect->save();


    if ($request->hasFile('file')) {

      //  

      // 2️⃣ Upload new files
      foreach ($request->file('file') as $file) {

        $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/files'), $filename);

        $suspect->files()->create([
          'file_path' => 'uploads/files/' . $filename,
          'file_type' => 'suspect'
        ]);
      }
    }

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
    $suspect = Suspect::join('provinces', 'suspects.province', '=', 'provinces.id')
      ->select(
        'suspects.*',
        'provinces.id as province_id',
        'provinces.name_da as province_name'
      )
      ->where('suspects.id', $id)
      ->firstOrFail();

    if (!empty($suspect->monitoring_date)) {
      $suspect->monitoring_date = $this->to_dari_date($suspect->monitoring_date);
    }


    return view('suspects.details', compact('suspect'));
  }




  // public function deleteFile($id)
  // {
  //   $file = SuspectFile::findOrFail($id);

  //   // Delete physical file
  //   if (file_exists(public_path($file->file_path))) {
  //     unlink(public_path($file->file_path));
  //   }

  //   $file->delete();

  //   return back()->with('success', 'فایل په بریالیتوب سره حذف شو.');
  // }
  public function showFiles($id)
  {
    $suspect = Suspect::with('files')->findOrFail($id);

    return view('suspects.files', compact('suspect'));
  }


  public function releaseFiles($id)
  {
    $suspect = Suspect::with('releaseFiles')->findOrFail($id);

    return view('suspects.release_files', compact('suspect'));
  }

  public function deleteReleaseFile($id)
  {

    $file = SuspectFile::findOrFail($id);

    if (file_exists(public_path($file->file_path))) {
      unlink(public_path($file->file_path));
    }

    $file->delete();

    return back()->with('success', 'فایل حذف شو');
  }

  public function getAuthorities(Request $request)
  {
    $search = $request->search;

    return Suspect::query()
      ->when($search, function ($query) use ($search) {
        $query->where('referring_authority', 'LIKE', "%$search%");
      })
      ->selectRaw('LOWER(TRIM(referring_authority)) as referring_authority')
      ->distinct()
      ->limit(50)
      ->get();


    return response()->json($data);
  }
}
