<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;


class NotesController extends Controller
{
    public function showNotes()
    {
        return view('notes');
    }

    public function showGroupNotes()
    {
        $allNotes = Note::all();
        $groupNotes = Note::where('option', 0)->get(); 
        return view('group_notes', ['notes' => $groupNotes]);

         // Add debugging information
         $debug = [
            'allNotesCount' => $allNotes->count(),
            'groupNotesCount' => $groupNotes->count(),
            'firstGroupNote' => $groupNotes->first(),
        ];

        return view('group_notes', [
            'notes' => $groupNotes,
            'debug' => $debug,
        ]);
    }

    public function getNotes()
    {
        $notes = Note::withCount('likes')->get()->map(function($note) {
            return [
                'id' => $note->id,
                'title' => $note->title,
                'liked' => $note->likes()->where('user_id', auth()->id())->exists(),
                'likeCount' => $note->likes_count,
            ];
        });

        return response()->json(['notes' => $notes]);
    }

    

    public function fetchNotes()
    {
        // Fetch public notes (option = 0)
        $publicNotes = Note::where('option', 0)->get();

        if ($publicNotes->isEmpty()) {
            return response()->json(['message' => 'No public notes found'], 404);
        }

        return response()->json($publicNotes);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'surah_name' => 'nullable|string',
            'ayah_num' => 'nullable|string',
            'ayah_verse_ar' => 'nullable|string',
            'ayah_verse_en' => 'nullable|string',
            'ayah_info' => 'nullable|string',
            'ayah_notes' => 'required|string',
            'option' => 'required|integer|in:0,1',  // 0 for public, 1 for private
            'is_speech_to_text' => 'boolean',
        ]);

        $validatedData['user_id'] = auth()->id();  // Automatically set the user ID

        $note = Note::create($validatedData);  // Create the note

        return response()->json(['message' => 'Note created successfully', 'note' => $note], 201);
    }

    public function updateNotes(Request $request, $id)
    {
        $validatedData = $request->validate([
            'surah_name' => 'nullable|string',
            'ayah_num' => 'nullable|string',
            'ayah_verse_ar' => 'nullable|string',
            'ayah_verse_en' => 'nullable|string',
            'ayah_info' => 'nullable|string',
            'ayah_notes' => 'required|string',
            'option' => 'required|integer|in:0,1',  // 0 for public, 1 for private
            'is_speech_to_text' => 'boolean',
        ]);

        $note = Note::findOrFail($id);
        $note->update($validatedData);

        return response()->json(['message' => 'Note updated successfully', 'note' => $note]);
    }

    public function deleteNotes($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully']);
    }

    
}
