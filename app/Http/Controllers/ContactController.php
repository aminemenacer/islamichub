<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;


class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'firstname',
            'lastname',
            'email',
            'mobile',
            'subject',
            'message'
        ]);

        $feedback = new Feedback();
        $feedback->firstname = $request->firstname;
        $feedback->lastname = $request->lastname;
        $feedback->email = $request->email;
        $feedback->mobile = $request->mobile;
        $feedback->subject = $request->subject;
        $feedback->message = $request->message;
        $feedback->save();
        
    }
}
