<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDebugbarServiceAndFacade();
        $this->registerCacheService();
    }

    /**
     * Register Debug Bar when working in local environment
     */
    protected function registerDebugbarServiceAndFacade()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->alias(\Barryvdh\Debugbar\Facade::class, 'Debugbar');
        }
    }

    /**
     * Register Laravel Cache Service
     */
    protected function registerCacheService()
    {
        $this->app->bind('App\Services\Contracts\CacheInterface', function($app) {
            return new \App\Services\Cache\LaravelCache($app['cache'], null, 60);
        });
    }
}