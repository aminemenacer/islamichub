<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AhadithController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/nawawi_book.json';

        $hadith = json_decode(file_get_contents($file_path), true);
        return view('hadith', compact('hadith'));
    }
}
