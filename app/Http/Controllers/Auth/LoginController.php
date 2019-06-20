<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

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
            'name' => $userGoogle->getName(),
            'email' => $userGoogle->getEmail(),
            'password' => ''
        ]);
    }
        Auth::login($user);

        return redirect()->route('/');
        
    }


}
