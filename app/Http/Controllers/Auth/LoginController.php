<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;

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
    protected $redirectTo = '/cart/show';

    /**
     * Handle a failed login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [
                "Cet identifiant et ce mot de passe n'existent pas.",
            ],
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * After the user is authenticated, set or forget the remembered email cookie.
     */
    protected function authenticated(Request $request, $user)
    {
        // If the user checked "remember", save their email in a long-lived cookie (30 days)
        if ($request->filled('remember')) {
            $cookie = cookie('remembered_email', $request->input($this->username()), 60 * 24 * 30);
            return redirect()->intended($this->redirectPath())->withCookie($cookie);
        }

        // Otherwise remove the cookie if present
        $forget = Cookie::forget('remembered_email');
        return redirect()->intended($this->redirectPath())->withCookie($forget);
    }
}
