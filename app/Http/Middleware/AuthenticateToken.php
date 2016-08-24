<?php

namespace Matchappen\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Matchappen\Services\EmailTokenGuard;

class AuthenticateToken
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  EmailTokenGuard $auth
     * @return void
     */
    public function __construct(EmailTokenGuard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(action('Auth\EmailTokenController@getEmail'));
            }
        }

        return $next($request);
    }
}
