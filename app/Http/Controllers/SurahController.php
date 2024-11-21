<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Information;
use App\Models\Tafseer;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    // Simplify retrieval of all surahs
    public function getSurat()
    {
        return response()->json(Surah::all());
    }

    // Fetch ayahs for a given Surah
    public function getAudioAyat($id)
    {
        $ayahs = Ayah::where('surah_id', $id)->get();

        if ($ayahs->isEmpty()) {
            return response()->json(['message' => 'No ayahs found for this surah'], 404);
        }

        return response()->json($ayahs);
    }

    // Get ayahs by Surah
    public function getAyahsBySurah($surahId)
    {
        $surah = Surah::with('ayahs')->find($surahId);

        return $surah ? response()->json($surah->ayahs) : response()->json(['error' => 'Surah not found'], 404);
    }

    // Get translation and transliteration for a Surah
    public function getTranslationBySurah($surahId)
    {
        $surah = Surah::with('ayahs')->find($surahId);

        if (!$surah) {
            return response()->json(['error' => 'Surah not found'], 404);
        }

        return response()->json([
            'translation' => $surah->translation ?? null,
            'transliteration' => $surah->transliteration ?? null,
            'ayahs' => $surah->ayahs,
        ]);
    }

    // Get translations for a specific Ayah
    public function getTranslationsForAyah($ayahId)
    {
        $ayah = Ayah::with('translations')->find($ayahId);

        return $ayah ? response()->json($ayah->translations) : response()->json(['message' => 'Ayah not found'], 404);
    }

    // Get specific translation for an Ayah
    public function getTranslationByAyah($ayahId)
    {
        $ayah = Ayah::find($ayahId);

        if (!$ayah) {
            return response()->json(['message' => 'Ayah not found'], 404);
        }

        return response()->json($ayah->translations);
    }

    // Get Ayahs by Surah ID
    public function getAyat(Request $request)
    {
        return response()->json(Ayah::where('surah_id', $request->surah_id)->get());
    }

    // Get Information for a specific Ayah
    public function getInformations(Request $request)
    {
        return response()->json(Information::with('ayah.surah')->where('ayah_id', $request->id)->first());
    }

    // Get Tafseer for a specific ID
    public function getTafseers($id)
    {
        return response()->json(Tafseer::find($id)->tafseer ?? null);
    }

    public function searchTranslations(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'results' => [],
                'suggestions' => []
            ]);
        }

        try {
            // Perform a query to search for the input text across multiple fields
            $results = Information::query()
                ->where(function ($subQuery) use ($query) {
                    $subQuery->where('translation', 'like', '%' . $query . '%')
                            ->orWhere('tafseer', 'like', '%' . $query . '%')
                            ->orWhere('transliteration', 'like', '%' . $query . '%');
                })
                ->with(['ayah.surah:id,name']) // Load only necessary fields for related data
                ->select('id', 'ayah_id', 'translation', 'tafseer', 'transliteration') // Select specific fields
                ->get();

            // Generate unique word suggestions
            $suggestions = $results->flatMap(function ($item) use ($query) {
                $words = [];
                foreach (['translation', 'tafseer', 'transliteration'] as $field) {
                    if (isset($item->$field)) {
                        preg_match_all('/\b\w*' . preg_quote($query, '/') . '\w*\b/i', $item->$field, $matches);
                        $words = array_merge($words, $matches[0]);
                    }
                }
                return $words;
            })->unique()->values();

            return response()->json([
                'results' => $results,
                'suggestions' => $suggestions,
            ]);
        } catch (\Exception $e) {
            // Log detailed error information for debugging
            \Log::error("Error executing search query: ", [
                'query' => $query,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Database query failed'], 500);
        }
    }





}
