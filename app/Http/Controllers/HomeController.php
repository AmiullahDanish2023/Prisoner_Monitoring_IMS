<?php

namespace App\Http\Controllers;
use App\Models\Content;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books             = Content::where('type', 1)->get()->count();
        $academic_articals = Content::where('type', 2)->get()->count();
        $research_articals = Content::where('type', 3)->get()->count();

        if(Session::get('locale') == 'en')
        {
            $setting  = Setting::where('language_id', 1)->first();
        } else if (Session::get('locale') == 'pa')
        {
            $setting  = Setting::where('language_id', 2)->first();
        }
        else {
            $setting  = Setting::where('language_id', 3)->first();
        }
        return view('home', compact('books', 'academic_articals', 'research_articals', 'setting'));
    }
}
