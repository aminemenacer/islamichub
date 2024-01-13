<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imam;
use App\Models\Chapter;



class AhadithController extends Controller
{
    public function index()
    {
        return view('ahadith');
    }

    public function getImams()
    {
        $imam = Imam::get();
        return response()->json($imam);
    }

    public function getChapters(Request $request)
    {
        $ayah = Chapter::where('surah_id', $request->surah_id)->get();
        return response()->json($ayah);
    }

    
}
