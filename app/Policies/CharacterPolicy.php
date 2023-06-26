<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Guild;
use App\Models\Character;

class CharacterPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function destroy(User $user, Character $character = NULL){
        if($character == NULL) return $user->role=='admin';
        return ($user->active_character_id === $character->id || $user->role=='admin');
    }
    public function show(User $user, Character $character){
        return ($user->active_character_id == $character->id || $user->role=='admin' || $user->role=='mod');
    }
    // public function index(User $user){
    //     return ($user->role=='mod');
    // }
}
