<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Policies\GuildPolicy;
use App\Policies\UserPolicy;
use App\Policies\CharacterPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Model\Guild' => 'App\Policies\GuildPolicy',
        'App\Model\User' => 'App\Policies\UserPolicy',
        'App\Model\Character' => 'App\Policies\CharacterPolicy',
        //Guild::class => GuildPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('delete-guild', [GuildPolicy::class, 'destroy']);
        Gate::define('join-guild', [GuildPolicy::class, 'join']);
        Gate::define('leave-guild', [GuildPolicy::class, 'leave']);
        Gate::define('update-guild', [GuildPolicy::class, 'update']);
        Gate::define('create-guild', [GuildPolicy::class, 'create']);
        Gate::define('update-user', [UserPolicy::class, 'update']);
        Gate::define('delete-user', [UserPolicy::class, 'destroy']);
        Gate::define('show-user', [UserPolicy::class, 'show']);
        Gate::define('index-users', [UserPolicy::class, 'index']);
        Gate::define('view-character', [CharacterPolicy::class, 'show']);
        Gate::define('delete-character', [CharacterPolicy::class, 'destroy']);
        $this->registerPolicies();
        //Gate::define('is-admin', function (User $user) { return $user->isAdmin(); });
    }
}
