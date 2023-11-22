<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Liked;



class CardsController extends Controller
{
    public function index()
    {
        // $file_path = '/cards/amine/Desktop/islamichub/storage/cards.json';

        // $cards = json_decode(file_get_contents($file_path), true);
        return view('cards');
    }

    public function submitLike(Request $request)
    {
       
        $card = new Liked();
        $card->surah = $request->surah;
        $card->ayaatiha = $request->ayaatiha;
        $card->maeni_tasmiatiha = $request->maeni_tasmiatiha;
        $card->asmawuha = $request->asmawuha;
        $card->maqsiduha_aleamu = $request->maqsiduha_aleamu;
        $card->sabab_nuzuliha = $request->sabab_nuzuliha;

        $card->fadluha = $request->fadluha;
        $card->munasabatiha = $request->munasabatiha;
        $card->save();
        
    }
   

    public function getCards()
    {
        $cards = Card::get();
        return $cards;
    }
    
}
