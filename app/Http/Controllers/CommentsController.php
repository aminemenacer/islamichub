<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Note;


class CommentsController extends Controller
{

    public function getComments(Note $note)
    {
        // Retrieve all comments for the note, including the associated note info
        $comments = $note->comments()->get();

        return response()->json($comments, 200); // Return comments in JSON format
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
