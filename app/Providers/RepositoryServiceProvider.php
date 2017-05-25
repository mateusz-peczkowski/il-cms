<?php

namespace App\Providers;

use App\Page;
use App\Control;
use App\Form;
use App\Language;
use App\Translation;
use App\User;
use App\Option;
use App\Redirect;
use App\Seo;
use App\Module;
use App\ModuleRecord;
use App\Observers\PageObserver;
use App\Observers\ControlObserver;
use App\Observers\FormObserver;
use App\Observers\OptionObserver;
use App\Observers\RedirectObserver;
use App\Observers\TranslationObserver;
use App\Observers\SeoObserver;
use App\Observers\ModuleObserver;
use App\Observers\ModuleRecordObserver;
use App\Observers\LanguageObserver;
use App\Observers\UserObserver;
use App\Repositories\Page\PageCacheDecorator;
use App\Repositories\Control\ControlCacheDecorator;
use App\Repositories\Form\FormCacheDecorator;
use App\Repositories\Redirect\RedirectCacheDecorator;
use App\Repositories\Seo\SeoCacheDecorator;
use App\Repositories\Module\ModuleCacheDecorator;
use App\Repositories\ModuleRecord\ModuleRecordCacheDecorator;
use App\Repositories\Language\LanguageCacheDecorator;
use App\Repositories\Option\OptionCacheDecorator;
use App\Repositories\Role\RoleCacheDecorator;
use App\Repositories\User\UserCacheDecorator;
use App\Repositories\Translation\TranslationCacheDecorator;
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
        Language::observe(LanguageObserver::class);
        Translation::observe(TranslationObserver::class);
        User::observe(UserObserver::class);
        Option::observe(OptionObserver::class);
        Redirect::observe(RedirectObserver::class);
        Form::observe(FormObserver::class);
        Control::observe(ControlObserver::class);
        Page::observe(PageObserver::class);
        Seo::observe(SeoObserver::class);
        Module::observe(ModuleObserver::class);
        ModuleRecord::observe(ModuleRecordObserver::class);
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
        $this->registerFormRepository();
        $this->registerControlRepository();
        $this->registerSubmitRepository();
        $this->registerPageRepository();
        $this->registerPageOptionRepository();
        $this->registerSeoRepository();
        $this->registerModuleRepository();
        $this->registerModuleRecordRepository();
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
            $redirect = new \App\Repositories\Redirect\EloquentRedirectRepository($app);

            return new RedirectCacheDecorator($redirect, ['redirect', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
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

    /*
     * Register Form repository
     */
    protected function registerFormRepository()
    {
        $this->app->bind('App\Repositories\Contracts\FormRepositoryInterface', function($app) {
            $form =  new \App\Repositories\Form\EloquentFormRepository($app);

            return new FormCacheDecorator($form, ['form', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register Control repository
     */
    protected function registerControlRepository()
    {
        $this->app->bind('App\Repositories\Contracts\ControlRepositoryInterface', function($app) {
            $control = new \App\Repositories\Control\EloquentControlRepository($app);

            return new ControlCacheDecorator($control, ['control', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register Submit repository
     */
    protected function registerSubmitRepository()
    {
        $this->app->bind('App\Repositories\Contracts\SubmitRepositoryInterface', function($app) {
            return new \App\Repositories\Submit\EloquentSubmitRepository($app);
        });
    }

    /*
     * Register Page repository
     */
    protected function registerPageRepository()
    {
        $this->app->bind('App\Repositories\Contracts\PageRepositoryInterface', function($app) {
            $page = new \App\Repositories\Page\EloquentPageRepository($app);

            return new PageCacheDecorator($page, ['page', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register PageOption repository
     */
    protected function registerPageOptionRepository()
    {
        $this->app->bind('App\Repositories\Contracts\PageOptionRepositoryInterface', function($app) {
            return new \App\Repositories\PageOption\EloquentPageOptionRepository($app);
        });
    }

    /*
     * Register Seo repository
     */
    protected function registerSeoRepository()
    {
        $this->app->bind('App\Repositories\Contracts\SeoRepositoryInterface', function($app) {
            $seo = new \App\Repositories\Seo\EloquentSeoRepository($app);

            return new SeoCacheDecorator($seo, ['seo', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register Module repository
     */
    protected function registerModuleRepository()
    {
        $this->app->bind('App\Repositories\Contracts\ModuleRepositoryInterface', function($app) {
            $module = new \App\Repositories\Module\EloquentModuleRepository($app);

            return new ModuleCacheDecorator($module, ['module', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }

    /*
     * Register ModuleRecord repository
     */
    protected function registerModuleRecordRepository()
    {
        $this->app->bind('App\Repositories\Contracts\ModuleRecordRepositoryInterface', function($app) {
            $module_record = new \App\Repositories\ModuleRecord\EloquentModuleRecordRepository($app);

            return new ModuleRecordCacheDecorator($module_record, ['module_record', 'updater'], $this->app->make('App\Services\Contracts\CacheInterface'));
        });
    }


}
