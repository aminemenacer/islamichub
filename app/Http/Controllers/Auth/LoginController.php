<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        $facebook_user = Socialite::driver('facebook')->user();
        
        $user = User::where('fb_id', $facebook_user->getId())->first();
    
        if(!$user){
            $new_user = User::create([
                'name' => $facebook_user->name,
                'email' => $facebook_user->email,
                'fb_id' => $facebook_user->getId(),
            ]);

            Auth::login($new_user);
            return redirect('/');
        }else{
            
            Auth::login($user);
            return redirect('/');
        }
    }
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $google_user = Socialite::driver('google')->user();

        $user = User::where('google_id', $google_user->getId())->first();

        if (!$user) {

        $new_user = User::create([
            'name' => $google_user->getName(),
            'email' => $google_user->getEmail(),
            'google_id' => $google_user->getId(),
        ]);

        Auth::login($new_user);
            return redirect('/');
        } else {

        Auth::login($user);
            return redirect('/');
        }
    }
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
