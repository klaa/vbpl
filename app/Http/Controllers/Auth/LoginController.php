<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $email = request()->input('email');
        $field = filter_var($email,FILTER_VALIDATE_EMAIL)?'email':'username';
        return $field;
    }

    /**
     * Redirect to Google 
     * @return void
     */
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google login
     * @param 
     */
    public function handleGoogleCallback() {
        $tmpuser = Socialite::driver('google')
                    ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                    ->user();

        $user = User::firstOrNew(['email'=>$tmpuser->getEmail()]);

        if(empty($user->id)) {
            $user->username = $tmpuser->getNickname();
            $user->name     = $tmpuser->getName();
            $user->password = Str::random();
            $user->save();   
        }
        
        Auth::login($user);

        return redirect()->route('home');
    }
}
