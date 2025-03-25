<?php

namespace App\Policies;

use App\Models\Matches;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MatchesPolicy
{

    public function modify(User $user, Matches $match): Response
    {
        
        return $user->id === $match->user_id
            ? Response::allow()
            : Response::deny('You do not have access to this match');
    }


}
