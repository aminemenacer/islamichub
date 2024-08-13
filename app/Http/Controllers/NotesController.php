<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function index()
    {
        return view('notes');
    }

    public function getNotes($userId)
    {
        $notes = Note::where('user_id', $userId)->get();
        return response()->json($notes);
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
            'is_speech_to_text' => 'boolean',
        ]);

        $validatedData['user_id'] = auth()->id();

        $note = Note::create($validatedData);

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