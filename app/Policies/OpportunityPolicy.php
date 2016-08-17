<?php

namespace Matchappen\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Matchappen\User;
use Matchappen\Opportunity;

class OpportunityPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function update(User $user, Opportunity $opportunity)
    {
        return $user->workplace_id === $opportunity->workplace_id;
    }
}
