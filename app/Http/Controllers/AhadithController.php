<?php

namespace App\Http\Controllers;

use App\Models\Ahadith;
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
        $chapter = Chapter::where('imam_id', $request->imam_id)->get();
        
        return response()->json($chapter);
    }

    public function getAhadith()
    {
        $ahadith = Ahadith::with('chapter')->get();
        return response()->json($ahadith);
    }

    // public function getAhadith($id)
    // {
    //     $ahadith = Ahadith::whereId($id)->first();
    //     return response()->json($ahadith->ahadith);
    // }

    public function search(Request $request)
    {
        $ahadith = Ahadith::with('chapter')->where('chapter_text', 'LIKE', "%{$request->chapter_text}%")->get();
        return response()->json($ahadith);
    }
}