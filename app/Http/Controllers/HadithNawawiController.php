<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nawawi;

class HadithNawawiController extends Controller
{
    public function index()
    {
        return view('nawawi');
    }

    public function getNawawis()
    {
        $nawawi = Nawawi::latest()->paginate(6);
        return $nawawi;
    }
}


