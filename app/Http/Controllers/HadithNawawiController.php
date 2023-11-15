<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HadithNawawiController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/three_main/nawawi_book.json';

        // $hadith_nawawi = json_decode(file_get_contents($file_path), true);
        // return view('hadith_nawawi', compact('hadith_nawawi'));

        $hadith = json_decode(file_get_contents($file_path), true);
        return view('hadith_nawawi', compact('hadith'));
    }
}
