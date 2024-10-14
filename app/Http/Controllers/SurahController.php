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

    // public function summarizeText(Request $request)
    // {
    //     $text = $request->input('text');

    //     // Check for empty input
    //     if (empty($text)) {
    //         return response()->json(['error' => 'No text provided for summarization.'], 400);
    //     }

    //     // A very simple summary approach: just return the first two sentences
    //     $sentences = preg_split('/(?<=[.!?])\s+/', $text);
    //     $summary = implode(' ', array_slice($sentences, 0, 2)); // Take the first two sentences

    //     return response()->json(['summary' => trim($summary)]);
    // }

    

    public function searchTranslations(Request $request)
    {
        $query = $request->input('query');
        $filters = $request->input('filters', []);

        // Initialize the results query
        $resultsQuery = Information::query();

        // Ensure the query is not empty
        if (empty($query)) {
            return response()->json([
                'results' => [],
                'suggestions' => [],
            ]);
        }

        // Build the query for the filtered search
        $filterApplied = false;

        if (!empty($filters['translation'])) {
            $resultsQuery->where('translation', 'LIKE', '%' . $query . '%');
            $filterApplied = true;
        }

        if (!empty($filters['tafseer'])) {
            $resultsQuery->orWhere('tafseer', 'LIKE', '%' . $query . '%');
            $filterApplied = true;
        }

        if (!empty($filters['transliteration'])) {
            $resultsQuery->orWhere('transliteration', 'LIKE', '%' . $query . '%');
            $filterApplied = true;
        }

        // If no filter is applied, return empty results
        if (!$filterApplied) {
            return response()->json([
                'results' => [],
                'suggestions' => [],
            ]);
        }

        // Eager load related ayah and surah
        $results = $resultsQuery->with(['ayah.surah'])->get();

        // Generate suggestions based on selected filters
        $suggestions = collect();

        // Check each result and generate suggestions based on the filters
        foreach ($results as $item) {
            if (!empty($filters['translation']) && isset($item->translation)) {
                preg_match_all('/\b\w*' . preg_quote($query, '/') . '\w*\b/i', $item->translation, $matches);
                $suggestions = $suggestions->merge($matches[0]);
            }

            if (!empty($filters['tafseer']) && isset($item->tafseer)) {
                preg_match_all('/\b\w*' . preg_quote($query, '/') . '\w*\b/i', $item->tafseer, $matches);
                $suggestions = $suggestions->merge($matches[0]);
            }

            if (!empty($filters['transliteration']) && isset($item->transliteration)) {
                preg_match_all('/\b\w*' . preg_quote($query, '/') . '\w*\b/i', $item->transliteration, $matches);
                $suggestions = $suggestions->merge($matches[0]);
            }
        }

        // Ensure suggestions are unique and indexed correctly
        $suggestions = $suggestions->unique()->values();

        // Return both the results and suggestions as JSON
        return response()->json([
            'results' => $results,
            'suggestions' => $suggestions,
        ]);
    }



}