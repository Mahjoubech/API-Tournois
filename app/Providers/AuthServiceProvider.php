<?php

namespace App\Providers;
use App\Models\Tournois;
use App\Policies\TournoisPolicy;
use App\Models\Players;
use App\Policies\PlayersPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
     
protected $policies = [
    Tournois::class => TournoisPolicy::class,
    Players::class => PlayersPolicy::class,
];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
