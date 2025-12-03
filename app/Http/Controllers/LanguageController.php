<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


class LanguageController extends Controller
{
    protected function en()
    {
        Session::put('locale', 'en');
        // dd(Session::get('locale'));
        // return redirect()->back();

        return redirect()->route('home');
    }
    protected function fa()
    {
        Session::put('locale', 'fa');
        // dd(Session::get('locale'));
        // return redirect()->back();

        return redirect()->route('home');
    }
    protected function pa()
    {
        Session::put('locale', 'pa');
        // dd(Session::get('locale'));
        // return redirect()->back();

        return redirect()->route('home');
    }
}
