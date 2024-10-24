<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Str;

class GoogleSocialAuthController extends Controller
{
    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle the callback from Google
    public function GoogleLoginCallback()
    {
        try {
            // Use stateless if you encounter state mismatch issues (not recommended for production)
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                Auth::login($user);
            } else {
                // Create a new user if one doesn't exist
                $user = User::create([
                    'first_name' => Str::before($googleUser->name, ' '),
                    'last_name' => Str::after($googleUser->name, ' '),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(8)), // Securely generate a random password
                    'register_type' => 2,
                    'register_method' => 3,
                    'register_method_id' => $googleUser->id,
                    'referral_code' => generate_rederal_code(),
                    'user_type' => 4,
                ]);
                Auth::login($user);

                $subscription_id = 1;

                $user_permission = setUserPermissionBaseOnSubscription($user->id, $subscription_id);

            }

            return redirect()->intended('/'); // Redirect to the desired page (home page)
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Google: ' . $e->getMessage());
        }
    }
}
