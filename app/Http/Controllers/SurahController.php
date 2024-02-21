<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Information;
use App\Models\Tafseer;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    
    public function getSurahs()
    {
        $surah = Surah::get();
        return response()->json($surah);
    }

    public function getAyahs(Request $request)
    {
        $ayah = Ayah::where('surah_id', $request->surah_id)->get();
        return response()->json($ayah);
    }

    public function getInformations(Request $request)
    {
        $information = Information::with('ayah')->where('ayah_id', $request->ayahId)->first();
        return response()->json($information);
    }

    public function getTafseer($id)
    {
        $tafseer = Tafseer::whereAyahId($id)->first();
        return response()->json($tafseer->tafseer);
        
    }
}