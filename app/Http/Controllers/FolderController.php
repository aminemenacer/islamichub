<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function index()
    {
       // Fetch all folders
       $folders = Folder::all();
       return response()->json(['folders' => $folders]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string']);

        // Access the folders relationship as a method to get the query builder
        $folder = Auth::user()->folders()->create($validated);

        return response()->json($folder, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(['name' => 'required|string']);

        // Find the folder belonging to the authenticated user
        $folder = Auth::user()->folders()->findOrFail($id);

        // Update the folder
        $folder->update($validated);

        return response()->json($folder);
    }

    public function destroy($id)
    {
        // Find the folder belonging to the authenticated user
        $folder = Auth::user()->folders()->findOrFail($id);

        // Delete the folder
        $folder->delete();

        return response()->noContent();
    }
}
