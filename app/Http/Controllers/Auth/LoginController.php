<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use Auth;

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

    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->is_admin)
            {
                return redirect()->route('admin.home');
            }else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('login')->with('error','Email-Address And Password Are Wrong.');
        }
          
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $getInfo = Socialite::driver('github')->user();

        $user = User::where('provider_id', $getInfo->id)->first();

        if (!$user)
        {
            $user = User::create([
                'name' => $getInfo->getName(),
                'email' => $getInfo->getEmail(),
                'provider' => 'github',
                'provider_id' => $getInfo->getId(),
                'password' => '',
                'is_admin' => false,
                'avatar' => $getInfo->getAvatar()
            ]);
        }

        Auth::login($user);

        if ($user->is_admin = 1)
        {
           return redirect()->route('admin.home');
        }
        else
        {
            return redirect()->route('home');
        }
    }
}
