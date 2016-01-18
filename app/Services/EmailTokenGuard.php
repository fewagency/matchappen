<?php
namespace Matchappen\Services;

use Session;

/**
 * An instance of this class handles the logins for token-authenticated users.
 *
 * This Guard is inspired by Illuminate\Contracts\Auth\Guard
 * Because we have no user repository pattern for these token-users, this class becomes the
 * interface for all authentication as well as privilege checking for token-users.
 */
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
     * Determine if an email address belongs to the current authenticated user.
     *
     * @param string $email
     * @return bool
     */
    public function checkEmail($email)
    {
        return $this->email() === $email;
    }

    /**
     * Determine if the current user is a supervisor.
     *
     * @return bool
     */
    public function checkSupervisor()
    {
        return (bool)$this->isSupervisorEmail($this->email());
    }

    /**
     * Determine if the supplied email address belongs to a supervisor.
     *
     * @return bool
     */
    public function isSupervisorEmail($email)
    {
        return (bool)preg_match(config('school.supervisor_email_regex'), $email);
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