<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Information;
use App\Models\Page;
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

    // public function getPages(Request $request)
    // {
    //     $pages = Page::where('ayah_id', $request->ayah_id)->get();
    //     return response()->json($pages);
    // }

    public function getInformations(Request $request)
    {
        $information = Information::where('ayah_id', $request->ayah_id)->get();
        return response()->json($information);
    }
}
