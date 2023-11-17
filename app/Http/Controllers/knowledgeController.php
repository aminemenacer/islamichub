<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class knowledgeController extends Controller
{
    public function index()
    {
        return view('knowledge');
    }
}
