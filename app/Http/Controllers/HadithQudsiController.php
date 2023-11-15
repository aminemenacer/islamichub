<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HadithQudsiController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/three_main/qudsi_book.json';

        $hadith_qudsi = json_decode(file_get_contents($file_path), true);
        return view('hadith_qudsi', compact('hadith_qudsi'));
    }
}
