<?php

namespace App\Policies;

use App\Models\Players;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlayersPolicy
{

    public function modify(User $user, Players $player): Response
    {
        
        return $user->id === $player->user_id
            ? Response::allow()
            : Response::deny('You do not have access to this player');
    }


}
