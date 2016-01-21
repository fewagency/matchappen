<?php

namespace Matchappen\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Matchappen\User;
use Matchappen\Workplace;

class WorkplacePolicy
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
        if ($user->is_admin) {
            return true;
        }
    }

    public function update(User $user, Workplace $workplace)
    {
        return $user->workplace_id === $workplace->getKey();
    }

    public function publish(User $user, Workplace $workplace)
    {
        return $user->is_admin;
    }
}
