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
        $bookmarks = Auth::user()->bookmarks()->with('folder')->get();
        return view('bookmark', compact('bookmarks'));
    }

    public function getBookmarks($userId)
    {
        $bookmarks = Bookmark::where('user_id', $userId)
            ->with('folder')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookmarks);
    }

    public function store(Request $request)
    {
        // Log the request data
        \Log::info('Request data:', $request->all());

        // Validate the request data
        $validated = $request->validate([
            'surah_name' => 'required|string|max:255',
            'ayah_num' => 'required|integer',
            'ayah_verse_ar' => 'required|string',
            'ayah_verse_en' => 'required|string',
            'folder_id' => 'required|exists:folders,id',
            'title' => 'nullable|string|max:255',
            'url' => 'nullable|string|url',
        ]);

        // Log the validated data
        \Log::info('Validated data:', $validated);

        // Ensure the folder belongs to the authenticated user
        $folder = Auth::user()->folders()->findOrFail($validated['folder_id']);

        // Create a new bookmark in the specified folder
        $bookmark = $folder->bookmarks()->create([
            'surah_name' => $validated['surah_name'],
            'ayah_num' => $validated['ayah_num'],
            'ayah_verse_ar' => $validated['ayah_verse_ar'],
            'ayah_verse_en' => $validated['ayah_verse_en'],
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Bookmark added successfully!', 'bookmark' => $bookmark], 201);
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


