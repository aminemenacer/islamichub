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
            'mistake_type' => 'required',
            // 'name' => 'string|min:3',
            // 'email' => 'string|email|max:255|unique:users',
            'added_notes' => 'required|string|min:5',
            // 'ayah_num' => 'integer',
        ]);

        $correction = new Correction();
        $correction->mistake_type = $request->mistake_type;
        // $correction->name = $request->name;
        // $correction->email = $request->email;
        $correction->added_notes = $request->added_notes;
        // $correction->ayah_num = $request->ayah_num;
        $correction->save();
    }

    public function deleteCorrections($id)
    {
        $correction = Correction::findOrFail($id);
        $correction->delete();
        return response()->json([
            'message' => 'Correction deleted successfully'
        ]);
    }
}
