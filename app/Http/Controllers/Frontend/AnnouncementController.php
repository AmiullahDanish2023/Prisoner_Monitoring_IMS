<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Validator;


class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($lang)
    {
        if($lang == 'en')
        {
            $announcement = Announcement::where('language_id', 1)->first();

        }else if($lang == 'pa'){
            $announcement = Announcement::where('language_id', 2)->first();
        }
        else if($lang == 'fa')
        {
            $announcement = Announcement::where('language_id', 3)->first();
        }

        return view('frontend.announcement.edit', compact('announcement'));
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
        $announcement = Announcement::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'د عنـــوان لیــــکل اړیــن ده',
            'description.required' => 'توضیــــحات لیـــکل اړیــــن دی',
        ]);

        $announcement->title        = $request->title;
        $announcement->description  = $request->description;
        $announcement->save();

        return response()->json(['status' => true, 'message' => 'معــلومات په مکـــمل توګه تغییــــر شول!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
