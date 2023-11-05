<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback');
    }

    public function getFeedbacks()
    {
        $feedback = Feedback::orderBy('id', 'desc')->get();
        return $feedback;
    }
}
