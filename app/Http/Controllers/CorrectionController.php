<?php

namespace App\Http\Controllers;

use App\Models\Correction;
use Illuminate\Http\Request;

class CorrectionController extends Controller
{

    public function index()
    {
        return view('correction');
    }

    public function getCorrections()
    {
        $correction = Correction::get();
        return $correction;
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'spelling_mistakes',
            'incomplete_text',
            'translation_error',
            'added_notes',
            'reference_error',
            'narrator',
            'hadith_english',
            'hadith_arabic'
        ]);

        $correction = new Correction();
        $correction->spelling_mistakes = $request->spelling_mistakes;
        $correction->incomplete_text = $request->incomplete_text;
        $correction->translation_error = $request->translation_error;
        $correction->added_notes = $request->added_notes;
        $correction->reference_error = $request->reference_error;
        $correction->narrator = $request->narrator;
        $correction->hadith_english = $request->hadith_english;
        $correction->hadith_arabic = $request->hadith_arabic;
        $correction->save();
    }
}
