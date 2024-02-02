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
        $correction = Correction::orderBy('id', 'desc')->get();
        return $correction;
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'mistake_type',
            'name',
            'email',
            'added_notes',
            'hadith_num'
        ]);

        $correction = new Correction();
        $correction->mistake_type = $request->mistake_type;
        $correction->name = $request->name;
        $correction->email = $request->email;
        $correction->added_notes = $request->added_notes;
        $correction->hadith_num = $request->hadith_num;
        $correction->save();
    }
}
