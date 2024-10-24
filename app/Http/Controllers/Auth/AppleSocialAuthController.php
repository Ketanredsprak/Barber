<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Auth;
use Exception;

class AppleSocialAuthController extends Controller
{
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        try {
            $user = Socialite::driver('apple')->user();

            dd($user);

            // Retrieve or create user in your database
            $existingUser = User::where('provider_id', $user->getId())->first();

            if ($existingUser) {
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'provider_id' => $user->getId(),
                    'provider' => 'apple',
                ]);

                Auth::login($newUser);
            }

            return redirect()->intended('/home');
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Failed to login with Apple.');
        }
    }
}
