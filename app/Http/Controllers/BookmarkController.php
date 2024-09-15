<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        // Retrieves bookmarks associated with the authenticated user
        $bookmarks = Auth::user()->bookmarks()->get();
        return view('bookmark', compact('bookmarks'));
    }

    public function getBookmarks($userId)
    {
        $bookmarks = Bookmark::where('user_id', $userId)->get();

        return response()->json($bookmarks);
    }

    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'surah_name' => 'required|string|max:255',
            'ayah_num' => 'required|integer',
            'ayah_verse_ar' => 'required|string',
            'ayah_verse_en' => 'required|string',
            'folder_id' => 'required|integer|exists:folders,id',
        ]);

        
    
        try {
            $bookmark = Bookmark::create($validatedData);
            return response()->json(['success' => true, 'message' => 'Bookmark saved successfully.', 'bookmark' => $bookmark], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save bookmark: ' . $e->getMessage()], 500);
        }
    }
    

    public function getBookmarksByFolder()
    {
        // Retrieve the folders and their associated bookmarks for the authenticated user
        $folders = Auth::user()->folders()->with('bookmarks')->get();

        return response()->json(['folders' => $folders]);
    }


    public function deleteBookmarks($id)
    {
        // Retrieve the bookmark by ID
        $bookmark = Bookmark::findOrFail($id);

        // Ensure the authenticated user owns the bookmark
        if (Auth::id() != $bookmark->user_id) {
            abort(403); // Forbidden
        }

        // Delete the bookmark
        $bookmark->delete();

        return response()->json(['message' => 'Bookmark deleted successfully']);
    }
}


