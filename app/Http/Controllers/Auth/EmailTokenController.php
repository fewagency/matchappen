<?php

namespace Matchappen\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Matchappen\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Matchappen\Services\EmailTokenGuard;
use Illuminate\Routing\UrlGenerator;

class EmailTokenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the log in of users authenticated with email and token
    | Inspired by \Illuminate\Foundation\Auth\AuthenticatesUsers and \Illuminate\Foundation\Auth\ResetsPasswords
    |
    */

    use ThrottlesLogins;

    /**
     * @var EmailTokenGuard
     */
    protected $guard;

    public function __construct(EmailTokenGuard $guard)
    {
        $this->middleware('input.trim:email,token');
        $this->guard = $guard;
    }

    public function getLogin($token, $email = null)
    {
        return view('auth.token_login')->with(compact('email', 'token'));
    }

    public function postLogin(Request $request, $token)
    {
        $this->validate($request, ['email' => 'required|email']);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $email = $request->input('email');

        if (!$this->guard->exists($token, $email)) {
            $this->incrementLoginAttempts($request);

            return redirect()->back()->withErrors(['email' => trans('auth.failed')])->withInput();
        }

        if ($token_url = $this->guard->attempt($token, $email)) {
            $this->clearLoginAttempts($request);

            return redirect(is_string($token_url) ? $token_url : $this->redirectPath());
        }

        return view('auth.token_invalidated');
    }

    public function getEmail()
    {
        //TODO: save previous() url as intended url in session - check auth middleware for inspiration
        return view('auth.token_email');
    }

    public function postEmail(Request $request, EmailTokenGuard $guard)
    {
        $this->validate($request, ['email' => 'required|email']); //TODO: validate email against the rules for school supervisor emails

        $email = $request->get('email');
        $token = $guard->generateAccessToken($email);

        //TODO: email token to supervisor

        return redirect()->back()->with('status', trans('auth.token_sent'));
    }

    public function getLogout(EmailTokenGuard $guard)
    {
        $guard->logout();

        return redirect('/');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'email';
    }

    /**
     * @return string url for redirect after successful login
     */
    public function redirectPath()
    {
        //TODO: check session for intended url
        return '/';
    }
}
