<?php

namespace App\Http\Controllers;

use App\Models\ReleaseSource;
use Illuminate\Http\Request;

class ReleaseSourceController extends Controller
{

    // Show all sources list
    public function index()
    {
        $sources = ReleaseSource::latest()->get();
        return view('release_sources.index', compact('sources'));
    }


    // Show create page
    public function create()
    {
        return view('release_sources.create');
    }

    // Store new source
    public function store(Request $request)
    {
        $request->validate([
            'name_da' => 'required'
        ]);

        ReleaseSource::create([
            'name_da' => $request->name_da,
            'name_pa' => $request->name_pa,
        ]);

        return redirect()->route('release-sources.index')
            ->with('success', 'مرجع په بریالیتوب سره اضافه شوه');
    }

    // Delete suspect
    // public function deleteSource($id)
    // {
    //     $deleteSource = ReleaseSource::findOrFail($id);
    //     $deleteSource->delete();
    //     return response()->json(['status' => true, 'message' => 'ریکارډ حذف شو']);
    // }

    public function updateSource(Request $request, $id)
    {
        $request->validate([
            'name_da' => 'required'
        ]);

        $source = ReleaseSource::findOrFail($id);

        $source->update([
            'name_da' => $request->name_da,
            'name_pa' => $request->name_pa,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'اپډیټ شو'
        ]);
    }
}
