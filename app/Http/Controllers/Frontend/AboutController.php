<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\Validator;
use File;


class AboutController extends Controller
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
            $about = About::where('language_id', 1)->first();

        }else if($lang == 'pa'){
            $about = About::where('language_id', 2)->first();
        }
        else if($lang == 'fa')
        {
            $about = About::where('language_id', 3)->first();
        }

        return view('frontend.about.edit', compact('about'));
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
        $imageName = '';
        $about = About::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',

        ], [
            'title.required' => 'د عنـــوان لیــــکل اړیــن ده',
            'description.required' => 'توضیــــحات لیـــکل اړیــــن دی',
        ]);

        $about->title        = $request->title;
        $about->description  = $request->description;

        $all_link_image_updates = About::get();

        if ($request->file('image')) {

            if(File::exists(public_path($about->image))){
                File::delete(public_path($about->image));
            }

            $image         = $request->image;
            $ext           = $image->getClientOriginalExtension();
            $imageName     = 'file_'.uniqid().'.'.$ext;
            $image->move(public_path('frontend/images'), $imageName);

            foreach($all_link_image_updates as $all_link_image_update)
            {
             $all_link_image_update->image  = "frontend/images/" . $imageName;
            }
        }

        foreach($all_link_image_updates as $all_link_image_update)
        {
            $all_link_image_update->video_link = $request->video_link;
            $all_link_image_update->save();
        }

        //  $about->video_link   = $request->video_link;



        $about->save();

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
