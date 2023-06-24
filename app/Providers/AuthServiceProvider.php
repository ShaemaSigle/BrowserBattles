<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Policies\GuildPolicy;
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
        $this->registerPolicies();
        //Gate::define('is-admin', function (User $user) { return $user->isAdmin(); });
    }
}
