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

    /**
     * Enter email to trigger token generation
     */
    public function getEmail(Request $request)
    {
        $intended_url = \URL::previous();
        if (!session('status') and $intended_url != action('Auth\AuthController@getLogin')) {
            $request->session()->put('url.intended', $intended_url);
        }

        return view('auth.token_email');
    }

    /**
     * Generate token
     */
    public function postEmail(Request $request, EmailTokenGuard $guard)
    {
        $this->validate($request,
            ['email' => ['required', 'email', 'regex:' . config('school.supervisor_email_regex')]]
        );

        $email = $request->get('email');
        $token = $guard->generateAccessToken($email);

        //TODO: email token to supervisor

        return redirect()->back()->with('status', trans('auth.token_sent'));
    }

    /**
     * Token link leads here for email+token validation
     */
    public function getLogin($token, $email = null)
    {
        return view('auth.token_login')->with(compact('email', 'token'));
    }

    /**
     * Validates email+token and logs in
     */
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

            if (is_string($token_url)) {
                return redirect($token_url);
            }

            return redirect()->intended($this->redirectPath());
        }

        return view('auth.token_invalidated');
    }

    /**
     * Log out token user
     */
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
     * @return string url for redirect after successful login or registration
     */
    public function redirectPath()
    {
        return route('dashboard');
    }
}
