<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{

    //
    public function redirect($service)
    {
        //dd($service);
        return Socialite::driver($service)->redirect();

    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();

    //    $getInfo = Socialite::driver($provider)->stateless()->user();
        // dd($provider);

        $user = User::where('email', $getInfo->email)->first();

        $login_google = $login_twitter = 0;
        if($provider == 'google'){
            $login_google = 1;
            $callback = 'Callback from Google';
        }
        else if($provider == 'twitter'){
            $login_twitter = 1;
            $callback = 'Callback from Twitter';
        }

        if (!$user) {
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'country' => $callback,
                'password' => Hash::make($getInfo->id),
                'login_via_google' => $login_google,
                'login_via_facebook' => $login_twitter
            ]);

            auth()->login($user);
            return redirect()->route('step');
        }else
        {

            auth()->login($user);
            return redirect()->route('dashboard');
        }


    }
}
