<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;


class ReminderController extends Controller
{
    public function index()
    {
        $file_path = '/Users/amine/Desktop/islamichub/storage/hasn_muslim.json';

        $reminder = json_decode(file_get_contents($file_path), true);
        return view('reminder', compact('reminder'));
    }
}
