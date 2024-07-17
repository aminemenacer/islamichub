<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Information;
use App\Models\Tafseer;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    
    public function getSurat()
    {
        $surat = Surah::get();
        return response()->json($surat);
    }

    public function getAyat(Request $request)
    {
        $ayat = Ayah::where('surah_id', $request->surah_id)->get();
        return response()->json($ayat);
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
