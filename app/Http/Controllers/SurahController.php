<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Information;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    public function getSurahs()
    {
        $data = Surah::get();
        return response()->json($data);
    }

    public function getAyahs(Request $request)
    {
        $data = Ayah::where('surah_id', $request->surah_id)->get();
        return response()->json($data);
    }

    public function getInformations(Request $request)
    {
        $data = Information::where('ayah_id', $request->ayah_id)->get();
        return response()->json($data);
    }
}
