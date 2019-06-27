<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;

class SocialiteController extends Controller
{
       /**
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function handlerProviderCallback()
    {
        $userGoogle = Socialite::driver('google')->user();
       // dd($userGoogle);
       $user = User::where('email' , $userGoogle->getEmail())->first();
        if(!$user){  
        $user = User::create([
                
            'nombreUsuario' => $userGoogle->getName(),
            'email' => $userGoogle->getEmail(),
            'password' => '',
            'google_id' => $userGoogle->getId(),
            
        ]);
    }
        auth::login($user);

        return redirect()->route('home');
        
    }
}
