<?php

namespace App\Http\Controllers;

use App\Models\Juz;
use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Information;
use App\Models\OverviewText;
use App\Models\Tafseer;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    public function getJuzs()
    {
        $juz = Juz::get();
        return response()->json($juz);
    }

    public function getSurahs(Request $request)
    {
        $surah = Surah::get();

        // $data = Surah::where('juz_id', $request->juz_id)->get();
        return response()->json($surah);
    }

    public function getAyahs(Request $request)
    {
        $ayah = Ayah::where('surah_id', $request->surah_id)->get();
        return response()->json($ayah);
    }

    public function getInformations(Request $request)
    {
        $information = Information::with('ayah')->where('ayah_id', $request->ayah_id)->first();
        return $information;
    }

    public function getTafseer($id)
    {

        $tafseer = Tafseer::whereId($id)->first();
        return response()->json($tafseer->tafseer);
    }
}
