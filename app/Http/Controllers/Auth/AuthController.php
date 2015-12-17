<?php

namespace Matchappen\Http\Controllers\Auth;

use Matchappen\User;
use Validator;
use Matchappen\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    //TODO: make postRegister() redirect to getLogin() withInput if the email exists
    //TODO: make postRegister() redirect to getLogin() withInput if user has triggered login action
    //TODO: if organization name is taken in postRegister(), link to the organisation for contact details

    //TODO: make postLogin() redirect to getRegister() withInput if user has triggered register action
    //TODO: make postLogin() redirect to Auth\PasswordController@getEmail withInput if user has triggered forgotten password action

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //TODO: validate User + Workplace
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        //TODO: create User + Workplace
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return action('Auth\AuthController@getLogin');
    }

    /**
     * @return string url for redirect after successful login or registration
     */
    public function redirectPath()
    {
        return route('dashboard');
    }

}
