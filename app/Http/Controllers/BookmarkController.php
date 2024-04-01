<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;


class BookmarkController extends Controller
{
    public function index()
    {
        return view('quran');
    }

    public function createBookmark(Request $request)
    {
        $this->validate($request, [
            'firstname',
            'email', 
        ]);

        $bookmark = new Bookmark();
        $bookmark->firstname = $request->firstname;
        $bookmark->email = $request->email;
        $bookmark->save();
    }
}
