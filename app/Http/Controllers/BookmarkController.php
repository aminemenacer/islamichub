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
        $bookmark = Auth::user()->bookmarks;
        return view('bookmark', compact('bookmark'));
    }

    public function getBookmarks($userId)
    {
        $bookmark = Bookmark::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return response()->json($bookmark);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'surah_name' => 'required|string|max:255',
            'ayah_num' => 'required|integer',
            'ayah_verse_ar' => 'required|string',
            'ayah_verse_en' => 'required|string',
        ]);

        $bookmark = new Bookmark();
        $bookmark->user_id = auth()->id(); // Assuming users are authenticated
        $bookmark->surah_name = $validatedData['surah_name'];
        $bookmark->ayah_num = $validatedData['ayah_num'];
        $bookmark->ayah_verse_ar = $validatedData['ayah_verse_ar'];
        $bookmark->ayah_verse_en = $validatedData['ayah_verse_en'];
        $bookmark->save();

        return response()->json(['message' => 'Bookmark saved successfully!']);
    }


    public function deleteBookmarks($id)
    {
       
        $bookmark = Bookmark::findOrFail($id);
        if (Auth::id() != $bookmark->user_id) {
            abort(403);
        }
        $bookmark->delete();
        return response()->json([
            'message' => 'Bookmark deleted successfully'
        ]); 
        
    }
}
