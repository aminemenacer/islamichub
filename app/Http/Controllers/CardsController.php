<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/cards.json';

        $cards = json_decode(file_get_contents($file_path), true);
        return view('cards', compact('cards'));
    }
}
