<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    // Redirect to Facebook for authentication
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle the callback from Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();


            dd($facebookUser);
            $user = User::where('facebook_id', $facebookUser->getId())->first();

            if ($user) {
                Auth::login($user);
            } else {
                // Create a new user if one doesn't exist
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'password' => encrypt('dummy_password'), // You can replace this with any other default or secure password
                ]);

                Auth::login($user);
            }

            return redirect()->intended('/services'); // Redirect to the desired page
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Facebook');
        }
    }
}
