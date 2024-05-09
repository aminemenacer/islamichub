<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{

    public function index()
    {
        return view('bookmark');
    }

    public function getBookmarks()
    {
        $bookmark = Bookmark::orderBy('id', 'desc')->get();
        return $bookmark;
    }

    public function store(Request $request)
    {  
        // Create a new bookmark instance
        $bookmark = new Bookmark();

        // Assign the user_id to the bookmark
        $bookmark->user_id = auth()->id(); // Assuming you are using Laravel's built-in authentication

        $bookmark->surah_name = $request->input('surah_name');
        $bookmark->ayah_num = $request->input('ayah_num');
        $bookmark->ayah_verse_ar = $request->input('ayah_verse_ar');
        $bookmark->ayah_verse_en = $request->input('ayah_verse_en');
        $bookmark->ayah_info = $request->input('ayah_info');
        // Save the bookmark
        $bookmark->save();

        // Return a success response
        return response()->json(['message' => 'Bookmark created successfully'], 201);
    }


    public function deleteBookmarks($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();
        return response()->json([
            'message' => 'Bookmark deleted successfully'
        ]);
    }
}
