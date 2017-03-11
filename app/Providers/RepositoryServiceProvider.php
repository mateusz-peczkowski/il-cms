<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoginAttemptsRepository();
    }

    /*
     * Register LoginAttempts repository
     */
    protected function registerLoginAttemptsRepository()
    {
        $this->app->bind('App\Repositories\Contracts\LoginAttemptsRepositoryInterface', function($app) {
            return new \App\Repositories\LoginAttempts\EloquentLoginAttemptsRepository($app);
        });
    }


}
