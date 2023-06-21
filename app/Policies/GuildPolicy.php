<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Guild;
use App\Models\Character;

class GuildPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Guild $guild){
        return $user->id === $guild->owner;
    }
    public function destroy(User $user, Guild $guild){
        return $user->active_character_id == $guild->owner;
    }
}
