<?php

namespace App\Providers;

use App\Language;
use App\Observers\OptionObserver;
use App\Observers\TranslationObserver;
use App\Option;
use App\Translation;
use App\User;
use App\Observers\LanguageObserver;
use App\Observers\UserObserver;
use App\Repositories\Language\LanguageCacheDecorator;
use App\Repositories\Option\OptionCacheDecorator;
use App\Repositories\Role\RoleCacheDecorator;
use App\Repositories\User\UserCacheDecorator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Translation\TranslationCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Language::observe(LanguageObserver::class);
        Translation::observe(TranslationObserver::class);
        User::observe(UserObserver::class);
        Option::observe(OptionObserver::class);
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
        $this->registerOptionRepository();
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
            $user = new \App\Repositories\User\EloquentUserRepository($app);

            return new UserCacheDecorator($user, ['user', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register Role repository
     */
    protected function registerRoleRepository()
    {
        $this->app->bind('App\Repositories\Contracts\RoleRepositoryInterface', function($app) {
            $role =  new \App\Repositories\Role\EloquentRoleRepository($app);

            return new RoleCacheDecorator($role, ['role'], $this->app->make('App\Services\Contracts\CacheInterface'));
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
            $translation = new \App\Repositories\Translation\EloquentTranslationRepository($app);

            return new TranslationCacheDecorator($translation, ['translation', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register Language repository
     */
    protected function registerLanguageRepository()
    {
        $this->app->bind('App\Repositories\Contracts\LanguageRepositoryInterface', function($app) {
            $language = new \App\Repositories\Language\EloquentLanguageRepository($app);

            return new LanguageCacheDecorator($language, ['language', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register Option repository
     */
    protected function registerOptionRepository()
    {
        $this->app->bind('App\Repositories\Contracts\OptionRepositoryInterface', function($app) {
            $option = new \App\Repositories\Option\EloquentOptionRepository($app);

            return new OptionCacheDecorator($option, ['option', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }


}
