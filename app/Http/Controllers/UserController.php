<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }

    public function getUsers()
    {
        $user = User::where('subscribe', '1')->orderBy('id', 'desc')->get();
        return $user;
    }

    public function getProfile()
    {
        return view('profile');
    }
}
