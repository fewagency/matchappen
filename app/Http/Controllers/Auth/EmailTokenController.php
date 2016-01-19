<?php

namespace Matchappen\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Matchappen\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Matchappen\Services\EmailTokenGuard;

class EmailTokenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the log in of users authenticated with email and token
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

    public function authenticate(Request $request, $token_string, $email = null)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $this->validate($request, ['email' => 'email']);

        $email = $request->input('email', $email);

        if (empty($email)) {
            return view('auth.token_login');
        }

        if (!$this->guard->exists($token_string, $email)) {
            $this->incrementLoginAttempts($request);

            return redirect($request->url())->withErrors(['email' => trans('auth.failed')])->withInput();
        }

        if ($token_url = $this->guard->attempt($token_string, $email)) {
            $this->clearLoginAttempts($request);

            return redirect(is_string($token_url) ? $token_url : $this->redirectPath());
        }

        return view('auth.token_invalidated');
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
        return '/';
    }
}
