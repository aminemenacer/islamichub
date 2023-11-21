<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Liked;



class CardsController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/cards.json';

        $cards = json_decode(file_get_contents($file_path), true);
        return view('cards', compact('cards'));
    }

    public function submitLike()
    {
        $cards = new Liked();
        $cards->save();
    }
   

    public function getCards()
    {
        $cards = Card::get();
        return $cards;
    }
    
}
