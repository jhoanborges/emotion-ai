<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleTwitterCallback()
    {
        // try {

        $user = Socialite::driver('twitter')->user();

        $finduser = User::where('twitter_id', $user->id)->first();

        if ($finduser) {

            Auth::login($finduser);

            return redirect()->intended('dashboard');

        } else {
            $newUser = User::updateOrCreate(['email' => $user->email], [
                'name' => $user->name,
                'twitter_id' => $user->id,
                'password' => encrypt('12345678'),
            ]);

            Auth::login($newUser);

            return redirect()->intended('dashboard');
        }

        /*} catch (Exception $e) {
            dd($e->getMessage());
        }*/
    }
}
