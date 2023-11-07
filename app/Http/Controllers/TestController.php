<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TestController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/test.json';

        $jsonData = json_decode(file_get_contents($file_path), true);
        return view('json-view', compact('jsonData'));}
}
