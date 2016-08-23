<?php

namespace Matchappen\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Matchappen\Services\EmailTokenGuard;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The token guard implementation
     *
     * @var EmailTokenGuard
     */
    protected $token_guard;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @param EmailTokenGuard $token_guard
     */
    public function __construct(Guard $auth, EmailTokenGuard $token_guard)
    {
        $this->auth = $auth;
        $this->token_guard = $token_guard;
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
        if ($this->auth->check() or $this->token_guard->check()) {
            return redirect(action('UserController@dashboard'));
        }

        return $next($request);
    }
}
