<?php

namespace Matchappen\Http\Controllers\Auth;

use Matchappen\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //TODO: make postEmail() redirect to getLogin() withInput if user has triggered login action

    /**
     * @return string url for redirect after successful password reset
     */
    public function redirectPath()
    {
        return route('dashboard');
    }


}
