<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Auth;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('doctors')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset($data->image) . '" class="card-rounded mw-100" alt="Image" style="width:50px; height:auto;"/>';
                })
                ->addColumn('action', function ($data) {
                    $edit = '';
                    $delete = '';
                if(Auth::user()->can('Edit Doctor')){
                    $edit = ' <a class="btn btn-primary btn-sm"  href="'. route('doctors.edit', $data->id) .'">
                   <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                    <path d="M3 17.25V21h3.75l11.75-11.75-3.75-3.75L3 17.25zM20.71 7.29a1 1 0 0 0 0-1.42l-2.58-2.58a1 1 0 0 0-1.42 0L15 5.59l3.75 3.75 1.96-1.96z" fill="currentColor"/>
                                                                                                                    </svg>
                    </a>';
                }
                if(Auth::user()->can('Delete Doctor')){
                    $delete = ' <button type="button" class="btn btn-sm btn-warning"  onclick="deleteData(' . $data->id . ');">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 6h18M6 6v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" fill="currentColor"/>
                            </svg>
                    </button>';
                }
                    return   $edit . ' ' . $delete;
                })

                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('Frontend.doctor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Frontend.doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name_pa' => 'required',
            'name_en' => 'required',
            'specialist_pa' => 'required',
            'specialist_en' => 'required',
            'image' => 'mimes:png,jpg'

        ], [
            'name_pa.required' => 'په پښتو کې نوم لیکل اړین دی',
            'name_en.required' => 'په انګلیسی کې نوم لیکل اړین دی',
            'specialist_pa.required' => 'د تخصص نوم لیکل اړین ده',
            'specialist_en.required' => 'د تخصص نوم په انګلیسی لیکل اړین ده',
            'image.mimes' => 'عکس بــاید پی ډی په جی په جې یا پی ان جی کې وی!!'
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors()->toArray());
        }

        $doctor = new Doctor();
        $doctor->name_pa           = $request->name_pa;
        $doctor->name_en           = $request->name_en;
        $doctor->specialist_pa     = $request->specialist_pa;
        $doctor->specialist_en     = $request->specialist_en;
        $doctor->about_pa          = $request->about_pa;
        $doctor->about_en          = $request->about_en;

        if ($request->hasFile('image')) {

            $image         = $request->image;
            $ext           = $image->getClientOriginalExtension();
            $imageName     = 'doctor_'.uniqid().'.'.$ext;

            $image->move(public_path('frontend/images/doctors'), $imageName);
            $doctor->image = "frontend/images/doctors/" . $imageName;
        }else{
            $doctor->image = "frontend/images/doctors/default_doctor.jpg";
        }

        $doctor->save();

        return response()->json(['status' => true, 'message' => 'Doctor store successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = Doctor::find($id);
        return view('Frontend.doctor.edit', compact('doctor'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $doctor = Doctor::where('id', $request->id)->first();

        $validator = Validator::make($request->all(), [
            'name_pa' => 'required',
            'name_en' => 'required',
            'specialist_pa' => 'required',
            'specialist_en' => 'required',
            'image' => 'mimes:png,jpg'

        ], [
            'name_pa.required' => 'په پښتو کې نوم لیکل اړین دی',
            'name_en.required' => 'په انګلیسی کې نوم لیکل اړین دی',
            'specialist_pa.required' => 'د تخصص نوم لیکل اړین ده',
            'specialist_en.required' => 'د تخصص نوم په انګلیسی لیکل اړین ده',
            'image.mimes' => 'عکس بــاید پی ډی په جی په جې یا پی ان جی کې وی!!'
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors()->toArray());
        }

        $doctor->name_pa           = $request->name_pa;
        $doctor->name_en           = $request->name_en;
        $doctor->specialist_pa     = $request->specialist_pa;
        $doctor->specialist_en     = $request->specialist_en;
        $doctor->about_pa          = $request->about_pa;
        $doctor->about_en          = $request->about_en;


        if ($request->file('image')) {

            if(File::exists(public_path($doctor->image))){
                File::delete(public_path($doctor->image));
            }

            $image     = $request->image;
            $ext           = $image->getClientOriginalExtension();
            $imageName = 'doctor_'.uniqid().'.'.$ext;

            $image->move(public_path('frontend/images/doctors'), $imageName);
            $doctor->image = "frontend/images/doctors/" . $imageName;
        }

        $doctor->save();

        return response()->json(['status' => true, 'message' => 'معــلومات په مکـــمل توګه تغییــــر شول!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->id;
        $doctor = DB::table('doctors')->find($id);

        if ($doctor) {

            $imagePath = public_path($doctor->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            DB::table('doctors')->where('id', $id)->delete();

            return response()->json(['status' => true, 'message' => 'معلومــــات په مکــــمل توګه حـــذب شو!']);
        } else {
            return response()->json(['status' => false, 'message' => '! System Error Call Administrator Of System']);
        }
    }
}
