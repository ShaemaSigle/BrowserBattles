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
        return $user->active_character_id === $guild->owner;
    }
    public function destroy(User $user, Guild $guild){
        return ($user->active_character_id == $guild->owner || $user->role=='admin');
    }
    public function join(User $user){
        $char = Character::findOrFail($user->active_character_id);
        return($char->guild_id == NULL);
    }
    public function leave(User $user, Guild $guild){
        $char = Character::findOrFail($user->active_character_id);
        return ($char->guild_id == $guild->id && $char->id != $guild->owner);
    }
    public function create(User $user){
        $char = Character::findOrFail($user->active_character_id);
        return ($char->guild_id == NULL);
    }
}
