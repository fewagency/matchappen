<?php

namespace Matchappen\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Matchappen\AccessToken;
use Matchappen\Workplace;
use Matchappen\Policies\WorkplacePolicy;
use Matchappen\Opportunity;
use Matchappen\Policies\OpportunityPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Workplace::class => WorkplacePolicy::class,
        Opportunity::class => OpportunityPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        /**
         * Generate a token string before creating AccessToken objects in database
         */
        AccessToken::creating(function (AccessToken $token) {
            return $token->generateToken();
        });
    }
}
