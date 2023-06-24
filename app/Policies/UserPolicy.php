<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Guild;
use App\Models\Character;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, User $userToChange){
        return ($user->id === $userToChange->id || $user->role=='admin');
    }
    public function destroy(User $user, User $userToChange){
        return ($user->id === $userToChange->id || $user->role=='admin');
    }
    public function show(User $user, User $userToChange){
        return ($user->id === $userToChange->id || $user->role=='admin');
    }
}
