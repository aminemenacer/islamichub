<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotesController extends Controller
{

    public function index()
    {
        return view('notes');
    }

    public function getNotes()
    {
        $note = Note::orderBy('id', 'desc')->get();
        return $note;
    }

    public function store(Request $request)
    {  
        // Create a new note instance
        $note = new Note();

        // Assign the user_id to the note
        $note->user_id = auth()->id(); // Assuming you are using Laravel's built-in authentication

        // Assign other fields from the request
        $note->surah_name = $request->input('surah_name');
        $note->ayah_num = $request->input('ayah_num');
        $note->ayah_text = $request->input('ayah_text');
        $note->ayah_notes = $request->input('ayah_notes');


        // Save the note
        $note->save();

        // Return a success response
        return response()->json(['message' => 'Note created successfully'], 201);
    }


    public function deleteNotes($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json([
            'message' => 'Note deleted successfully'
        ]);
    }
}