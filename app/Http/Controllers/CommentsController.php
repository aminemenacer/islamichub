<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Note;


class CommentsController extends Controller
{

    public function show(Note $note)
    {
        // This will automatically resolve the Note instance
        return response()->json($note);
    }

    public function getComments(Note $note)
    {
        $comments = $note->comments()->get();
        return response()->json($comments);
    }

    public function getNoteById($noteId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        return response()->json($note);
    }


    public function store(Request $request)
    {
        $request->validate([
            'note_id' => 'required|exists:notes,id',
            'comment' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'note_id' => $request->note_id,
            'comment' => $request->comment,
        ]);

        return response()->json($comment, 201); // Return the created comment with a success status
    }
}
