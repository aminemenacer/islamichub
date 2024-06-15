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
        $information = Information::with('ayah.surah')->where('id', $request->id)->first();
        return response()->json($information);
    }

    public function getTafseers($id)
    {
        $tafseer = Tafseer::whereId($id)->first();
        return response()->json($tafseer->tafseer);
    }

    public function search(Request $request)
    {
        $surah = Surah::with('surah')
            ->where('name_en', 'LIKE', "%{$request->name_en}%")
            ->where('name_ar', 'LIKE', "%{$request->name_ar}%")
            ->get();
        return response()->json($surah);
    }

}

