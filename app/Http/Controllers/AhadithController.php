<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ahadith;



class AhadithController extends Controller
{
    public function index()
    {
        return view('ahadith');
    }

    
}
