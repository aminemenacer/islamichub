<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AllahNamesController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/allah_names.json';

        $allah_names = json_decode(file_get_contents($file_path), true);
        return view('allah_names', compact('allah_names'));
    }
}
