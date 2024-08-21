<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
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
        // Retrieves bookmarks for a specific user
        $bookmarks = Bookmark::where('user_id', $userId)
            ->with('folder')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookmarks);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'surah_name' => 'required|string|max:255',
            'ayah_num' => 'required|integer',
            'ayah_verse_ar' => 'required|string',
            'ayah_verse_en' => 'required|string',
            'folder_id' => 'exists:folders,id',
            'title' => 'string|max:255',
            'url' => 'string|url',
        ]);

        // Ensure the folder belongs to the authenticated user
        $folder = Auth::user()->folders()->findOrFail($validated['folder_id']);

        // Create a new bookmark in the specified folder
        $bookmark = $folder->bookmarks()->create([
            // 'title' => $validated['title'],
            // 'url' => $validated['url'],
            'surah_name' => $validated['surah_name'],
            'ayah_num' => $validated['ayah_num'],
            'ayah_verse_ar' => $validated['ayah_verse_ar'],
            'ayah_verse_en' => $validated['ayah_verse_en'],
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Bookmark added successfully!', 'bookmark' => $bookmark], 201);
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

