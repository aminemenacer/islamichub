<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProphetsController extends Controller
{
    public function index()
    {
        return view('prophets');
    }
}
