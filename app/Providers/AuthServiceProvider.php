<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('cachedUser', function($app, array $config) {
            $model = $app->make('App\Repositories\Contracts\UserRepositoryInterface');
            $cache = $app->make('App\Services\Contracts\CacheInterface');

            return new CachedUserProvider($this->app['hash'], $model, $cache, ['user', 'updater']);
        });
    }
}
