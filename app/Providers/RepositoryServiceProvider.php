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
        $this->registerUserRepository();
        $this->registerRoleRepository();
        $this->registerRedirectRepository();
        $this->registerTranslationRepository();
        $this->registerLanguageRepository();
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

    /*
     * Register User repository
     */
    protected function registerUserRepository()
    {
        $this->app->bind('App\Repositories\Contracts\UserRepositoryInterface', function($app) {
            return new \App\Repositories\User\EloquentUserRepository($app);
        });
    }

    /*
     * Register Role repository
     */
    protected function registerRoleRepository()
    {
        $this->app->bind('App\Repositories\Contracts\RoleRepositoryInterface', function($app) {
            return new \App\Repositories\Role\EloquentRoleRepository($app);
        });
    }

    /*
     * Register Redirect repository
     */
    protected function registerRedirectRepository()
    {
        $this->app->bind('App\Repositories\Contracts\RedirectRepositoryInterface', function($app) {
            return new \App\Repositories\Redirect\EloquentRedirectRepository($app);
        });
    }

    /*
     * Register Translation repository
     */
    protected function registerTranslationRepository()
    {
        $this->app->bind('App\Repositories\Contracts\TranslationRepositoryInterface', function($app) {
            return new \App\Repositories\Translation\EloquentTranslationRepository($app);
        });
    }

    /*
     * Register Language repository
     */
    protected function registerLanguageRepository()
    {
        $this->app->bind('App\Repositories\Contracts\LanguageRepositoryInterface', function($app) {
            return new \App\Repositories\Language\EloquentLanguageRepository($app);
        });
    }


}
