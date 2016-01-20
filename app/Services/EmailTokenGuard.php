<?php
namespace Matchappen\Services;

use Carbon\Carbon;
use Session;
use Matchappen\AccessToken;

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
     * Validate a user's credentials.
     *
     * @param string $token
     * @param string $email
     * @return bool if the token exists
     */
    public function exists($token, $email)
    {
        $token = $this->getToken($token, $email);
        if ($token->exists) {
            return true;
        }

        $token->logUsage('missing');

        return false;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param string $token
     * @param string $email
     * @return string|bool false if not valid for use
     */
    public function attempt($token, $email)
    {
        $token = $this->getToken($token, $email);

        if (empty($token)) {
            return false;
        } elseif ($token->isExpired()) {
            $token->logUsage('expired');

            return false;
        } elseif (!$token->isUsable()) {
            $token->logUsage('used');

            return false;
        }

        $this->login($email);
        $token->logUsage('success');

        return $token->object_action ? $token->getObjectUrl() : true;
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
        //Also forget list of authenticated entities - if we create that feature
    }

    /**
     * Get a stored token, or a new instance if not found
     * @param string $token
     * @param string $email
     * @return AccessToken
     */
    protected function getToken($token, $email)
    {
        return AccessToken::firstOrNew(compact('token', 'email'));
    }

    /**
     * Generate a new token for general login
     * @param $email
     * @param Carbon|null $valid_until defaults to 1 hour
     * @return AccessToken
     */
    public function generateAccessToken($email, Carbon $valid_until = null)
    {
        $token = new AccessToken(['email' => $email, 'valid_until' => $valid_until ?: Carbon::parse('+1 hour')]);
        $token->save();

        return $token;
    }
}