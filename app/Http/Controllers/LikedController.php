<?php

namespace App\Http\Controllers;

use App\Models\Liked;
use Illuminate\Http\Request;

class LikedController extends Controller
{
    public function index()
    {
        return view('likes');
    }

    public function getLikes()
    {
        $liked = Liked::orderBy('id', 'desc')->get();
        return $liked;
    }
}
