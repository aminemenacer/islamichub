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
        $bookmark = Bookmark::where('user_id', $userId)->get();
        return response()->json($bookmark);
    }

    public function store(Request $request)
    {
        $request->validate([
            'surah_name' => 'required',
            'ayah_num' => 'required',
            'ayah_verse_ar' => 'required',
            'ayah_verse_en' => 'required',
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'notes' => 'nullable|string',
            'collection_id' => 'required|exists:collections,id',
        ]);

        // Create a new bookmark instance
        $bookmark = new Bookmark([
            'surah_name' => $request->input('surah_name'),
            'ayah_num' => $request->input('ayah_num'),
            'ayah_verse_ar' => $request->input('ayah_verse_ar'),
            'ayah_verse_en' => $request->input('ayah_verse_en'),
            'ayah_info' => $request->input('ayah_info'),
        ]);

        // Assign the user_id to the bookmark
        $bookmark->user_id = Auth::id();

        // Save the bookmark
        $bookmark->save();

        // Return a success response
        return response()->json(['message' => 'Bookmark created successfully'], 201);
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
