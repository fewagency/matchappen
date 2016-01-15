<?php
namespace Matchappen\Services;

use Session;

class EmailTokenGuard
{
    /**
     * @var string the key for storing the currently authenticated email address in session
     */
    public $email_session_key = 'token_authenticated_email';

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return (bool)$this->email();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated email address
     *
     * @return string|null email address
     */
    public function email()
    {
        return Session::get($this->email_session_key);
    }

    /**
     * Log a user into the application.
     *
     * @param string $email to log in
     */
    public function login($email)
    {
        Session::set($this->email_session_key, $email);
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        Session::forget($this->email_session_key);
        //TODO: forget list of authenticated entities
    }
}