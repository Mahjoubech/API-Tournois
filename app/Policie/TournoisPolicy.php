<?php

namespace App\Policies;

use App\Models\Tournois;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TournoisPolicy
{

    public function modify(User $user, Tournois $tournois): Response
    {
        return $user->id === $tournois->user_id ? Response::allow() : Response::deny('You do not access on this tournois');
    }
}
