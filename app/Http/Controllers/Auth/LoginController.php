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

    // facebook

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {
            $facebook_user = Socialite::driver('facebook')->user();
            $user = User::where('facebook_id', $facebook_user->getId())->orWhere('email', $facebook_user->getEmail())->first();

            if ($user) {
                // Update Facebook ID if the user exists but does not have a Facebook ID
                if (!$user->facebook_id) {
                    $user->facebook_id = $facebook_user->getId();
                    $user->save();
                }
            } else {
                $user = User::create([
                    'name' => $facebook_user->getName(),
                    'email' => $facebook_user->getEmail(),
                    'facebook_id' => $facebook_user->getId(),
                    // You may want to handle other fields as well
                ]);
            }

            Auth::login($user, true);
            return redirect($this->redirectTo);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Unable to login using Facebook. Please try again.']);
        }
    }

    // linkedin
    
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedinCallback()
    {
        try {
            $linkedin_user = Socialite::driver('linkedin')->user();
            $user = User::where('linkedin_id', $linkedin_user->getId())->orWhere('email', $linkedin_user->getEmail())->first();

            if ($user) {
                Auth::login($user, true);
            } else {
                $newUser = User::create([
                    'name' => $linkedin_user->getName(),
                    'email' => $linkedin_user->getEmail(),
                    'linkedin_id' => $linkedin_user->getId(),
                ]);
                Auth::login($newUser, true);
            }

            Auth::login($user, true);
            return redirect($this->redirectTo);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Unable to login using Facebook. Please try again.']);
        }
    }

    // google
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if the user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // If user already exists, log them in
                Auth::login($user);
            } else {
                // If user does not exist, create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    // Assuming 'user_id' is nullable and not needed here
                ]);

                Auth::login($user);
            }

            return redirect()->route('home');
        } catch (\Exception $e) {

            return redirect()->route('login')->with('error', 'Unable to login using Google.');
        }
    }

    
    /**
     * Logout the user.
     
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