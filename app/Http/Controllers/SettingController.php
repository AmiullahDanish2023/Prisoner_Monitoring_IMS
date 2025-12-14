<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use File;
// use Illuminate\Validation\Rules\File;

class SettingController extends Controller
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
            $setting = Setting::where('language_id', 1)->first();

        }else if($lang == 'pa'){

            $setting = Setting::where('language_id', 2)->first();
        }
        else if($lang == 'fa')
        {
            $setting = Setting::where('language_id', 3)->first();
        }

        return view('Frontend.setting.edit', compact('setting'));

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
        $setting_name_location = Setting::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'number' => 'required',
            'email' => 'required',
            'logo' => 'required|mimes:pdf,jpg'
        ], [
            'name.required' => 'د نوم لیــــکل اړیــن ده',
            'location.required' => 'د آدرس لیـــکل اړیــــن دی',
            'name.required' => 'د نمبر لیــــکل اړیــن ده',
            'location.required' => 'ایمیل لیـــکل اړیــــن دی',
            'logo.mimes' => 'فــایل بــاید پی ډی ایف، عکس، یا ورډ وی!!'
        ]);


        $setting_name_location->name         = $request->name;
        $setting_name_location->location     = $request->location;
        $setting_name_location->main_text    = $request->main_text;
        $setting_name_location->save();


        $settings = Setting::get();

        foreach($settings as $setting)
        {
            $setting->number             = $request->number;
            $setting->email              = $request->email;
            $setting->facebook_link      = $request->facebook_link;
            $setting->instagram_link     = $request->instagram_link;
            $setting->twiter_link        = $request->twiter_link;
            $setting->linkedin_link      = $request->linkedin_link;

            $setting->save();
        }

        if ($request->file('logo')) {

            if(File::exists(public_path($setting->logo))){
                File::delete(public_path($setting->logo));
            }

            $logo         = $request->logo;
            $ext           = $logo->getClientOriginalExtension();
            $logoName = 'logo_'.uniqid().'.'.$ext;
            $logo->move(public_path('frontend/logo'), $logoName);

            foreach($settings as $setting){
                $setting->logo = "frontend/logo/" . $logoName;
                $setting->save();
            }
        }


        $setting->save();

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
