<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HadithShahController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/three_main/shah_book.json';

        $hadith_shah = json_decode(file_get_contents($file_path), true);
        return view('hadith_shah', compact('hadith_shah'));
    }
}
