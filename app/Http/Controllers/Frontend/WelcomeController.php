<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\About;
use App\Models\Doctor;
use App\Models\Content;
use App\Models\Setting;
use App\Models\Announcement;

class WelcomeController extends Controller
{
    protected function en()
    {
        Session::put('locale', 'en');
        // dd(Session::get('locale'));
        // return redirect()->back();

        return redirect()->back();
    }
    protected function fa()
    {
        Session::put('locale', 'fa');
        // dd(Session::get('locale'));
        // return redirect()->back();

        return redirect()->back();
    }
    protected function pa()
    {
        Session::put('locale', 'pa');
        // dd(Session::get('locale'));
        // return redirect()->back();

        return redirect()->back();
    }

    public function welcome(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('contents')->get();

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('card', function ($data) {

                    $bookType = '';
                    if ($data->type == 1) {
                        $bookType = __('translate.book');
                    } elseif ($data->type == 2) {
                        $bookType = __('translate.academic artical');
                    } elseif ($data->type == 3) {
                        $bookType = __('translate.research artical');
                    }

                   return '
                    <div class="row justify-content-center my-2">
                        <div class="col-md-3 col-sm-6 my-2 book_item">
                            <div class="card book_item-card card-block">
                                <div class="book-img book_thumbnail">
                                    <img src="' . asset($data->thumbnail) . '" alt="Photo" />
                                </div>
                                <h4 class="book_item-card-title">
                                    <a>
                                        ' . $data->title . '
                                    </a>
                                </h4>
                                <h5 class="book_item-card-author mb-0">
                                    <span class="d-flex"> <span class="meta_data">
                                            '. __('translate.author') .':
                                        </span> ' . $data->author . '</span>
                                </h5>
                                <div class="">
                                    <p id="meta_data_size_andNO_of_pages" class="mx-2 mt-1 mb-1">
                                        (' . $data->size . 'kb)
                                        <span class="mx-2">(' . $data->total_page . ') ' . __('translate.pages') . '</span>
                                        <span class="">('. $bookType .')
                                        </span>
                                    </p>
                                    <a href="' . route('contents.download', $data->id) . '" class="btn btn-xs mt-1 "><i class="fa fa-download"></i></a>
                                    <a href="' . route('book_detial.show', $data->id) . '" class="btn btn-xs mt-1"> <i
                                            class="fa fa-eye" aria-hidden="true"></i>
                                             ' . __('translate.details') . '</a>
                                </div>
                            </div>
                        </div>
                        </div>
                        ';
                })

                ->rawColumns(['card'])
                ->make(true);

        }

        $doctors = Doctor::limit(4)->orderBy('id', 'desc')->get();

        if(Session::get('locale') == 'en')
        {
            $about   = About::where('language_id', 1)->first();
            $setting = Setting::where('language_id', 1)->first();
            $announcemet = Announcement::where('language_id', 1)->first();
        }
        else if(Session::get('locale') == 'pa'){
            $about   = About::where('language_id', 2)->first();
            $setting = Setting::where('language_id', 2)->first();
            $announcemet = Announcement::where('language_id', 2)->first();
        }
        else if(Session::get('locale') == 'fa')
        {
            $about   = About::where('language_id', 3)->first();
            $setting = Setting::where('language_id', 3)->first();
            $announcemet = Announcement::where('language_id', 3)->first();

        }

        $all_doctors = Doctor::get()->count();
        $all_books   = Content::where('type', 1)->get()->count();
        $all_articals = Content::whereIn('type', [2, 3])->count();


        return view('welcome', compact('about', 'doctors', 'setting', 'all_doctors', 'all_books', 'all_articals', 'announcemet'));
    }


    public function all_books(Request $request, $content)
    {
        if ($request->ajax()) {

            if($content == 1)
            {
                $data = DB::table('contents')->get();
            }else{

                $data = DB::table('contents')->whereIn('type', $content == 2 ? [1] : [2, 3])->get();
            }
            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('card', function ($data) {

                    $bookType = '';
                    if ($data->type == 1) {
                        $bookType = __('translate.book');
                    } elseif ($data->type == 2) {
                        $bookType = __('translate.academic artical');
                    } elseif ($data->type == 3) {
                        $bookType = __('translate.research artical');
                    }

                   return '
                    <div class="row "   style="background-color:#F1F7FD;">
                        <div class="col-md-3 col-sm-6 m-2 book_item">
                            <div class="card book_item-card card-block">
                                <div class="book-img book_thumbnail">
                                    <img src="' . asset($data->thumbnail) . '" alt="Photo of sunset" />
                                </div>
                                <h4 class="book_item-card-title">
                                    <a>
                                        ' . $data->title . '
                                    </a>
                                </h4>
                                <h5 class="book_item-card-author mb-0">
                                    <span class="d-flex"> <span class="meta_data">
                                            '. __('translate.author') .' :
                                        </span> ' . $data->author . '</span>
                                </h5>
                                <div class="">
                                    <p id="meta_data_size_andNO_of_pages" class="mx-2 mt-1 mb-1">
                                        (' . $data->size . 'kb)
                                        <span class="mx-2">(' . $data->total_page . ') ' . __('translate.pages') . '</span>
                                        <span class="">('. $bookType .')
                                        </span>
                                    </p>
                                    <button class="btn btn-sm mt-1 "><i class="fa fa-download"></i></button>
                                    <a href="' . route('book_detial.show', $data->id) . '" class="btn btn-sm mt-1"> <i
                                            class="fa fa-eye" aria-hidden="true"></i>
                                            ' . __('translate.details') . '</a>
                                </div>
                            </div>
                        </div>
                        </div>
                        ';
                })

                ->rawColumns(['card'])
                ->make(true);

        }
    }

    public function show($id)
    {
        $content = Content::where('id', $id)->first();

        if(Session::get('locale') == 'en')
        {
            $setting = Setting::where('language_id', 1)->first();


        }
        else if(Session::get('locale') == 'pa'){
            $setting = Setting::where('language_id', 2)->first();

        }
        else if(Session::get('locale') == 'fa')
        {
            $setting = Setting::where('language_id', 3)->first();

        }

        return view('frontend.pages.book_details', compact('content', 'setting'));
}
}
