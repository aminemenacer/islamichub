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
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginWithFacebook()
    {
        $facebook_user = Socialite::driver('facebook')->user();
        
        $user = User::where('fb_id', $facebook_user->getId())->first();
    
        if (!$user) {
            $new_user = User::create([
                'name' => $facebook_user->name,
                'email' => $facebook_user->email,
                'fb_id' => $facebook_user->getId(),
            ]);

            Auth::login($new_user);
            return redirect('/');
        } else {
            Auth::login($user);
            return redirect('/');
        }
    }
    
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
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
    
    /**
     * Logout the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
