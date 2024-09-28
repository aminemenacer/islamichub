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

    public function getAyahsBySurah($surahId)
    {
        $surah = Surah::with('ayahs')->find($surahId); // Eager load the ayahs

        if (!$surah) {
            return response()->json(['error' => 'Surah not found'], 404);
        }

        return response()->json($surah->ayahs); // Return the ayahs
    }

    public function getTranslationBySurah($surahId)
    {
        // Fetch the Surah by ID
        $surah = Surah::with('ayahs')->find($surahId);

        if (!$surah) {
            return response()->json(['error' => 'Surah not found'], 404);
        }

        // Assuming you want to get the translation and transliteration
        return response()->json([
            'translation' => $surah->translation, // Adjust based on your actual field names
            'transliteration' => $surah->transliteration,
            'ayahs' => $surah->ayahs,
        ]);
    }

    public function getTranslationsForAyah($ayahId)
    {
        $ayah = Ayah::with('translations')->find($ayahId); // Ensure that 'translations' is a defined relationship in your Ayah model

        if (!$ayah) {
            return response()->json(['message' => 'Ayah not found'], 404);
        }

        return response()->json($ayah->translations);
    }

    public function getTranslationByAyah($ayahId)
    {
        $ayah = Ayah::find($ayahId);

        if (!$ayah) {
            return response()->json(['message' => 'Ayah not found'], 404);
        }

        // Assuming you have a Translation model linked to Ayah
        $translation = $ayah->translations; // Adjust according to your actual relationship

        return response()->json($translation);
    }




    public function getAyat(Request $request)
    {
        $ayat = Ayah::where('surah_id', $request->surah_id)->get();
        return response()->json($ayat);
    }

    public function getInformations(Request $request)
    {

        $information = Information::with('ayah.surah')->where('ayah_id', $request->id)->first();
        return response()->json($information);
    }

    public function getTafseers($id)
    {
        $tafseer = Tafseer::whereId($id)->first();
        return response()->json($tafseer->tafseer);
    }

    public function searchTranslations(Request $request)
    {
        $query = $request->input('query');
        $filters = $request->input('filters');

        $resultsQuery = Information::query();

        // Apply filters based on the user's checkbox selection
        if ($filters['translation']) {
            $resultsQuery->orWhere('translation', 'like', '%' . $query . '%');
        }
        if ($filters['tafseer']) {
            $resultsQuery->orWhere('tafseer', 'like', '%' . $query . '%');
        }
        if ($filters['transliteration']) {
            $resultsQuery->orWhere('transliteration', 'like', '%' . $query . '%');
        }

        // Eager load related ayah and surah
        $results = $resultsQuery->with(['ayah.surah'])->get();

        return response()->json($results);
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
