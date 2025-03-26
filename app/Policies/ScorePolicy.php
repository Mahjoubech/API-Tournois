<?php

namespace App\Policies;

use App\Models\Score;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScorePolicy
{
   public function modify(User $user,Score $score){
    return $user->id === $score->user_id
    ?Response::allow() : Response::deny('You do not have access to this Score ');
   }
}
