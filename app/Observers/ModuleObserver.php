<?php

namespace App\Observers;

use App\Module;

class ModuleObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Module $module)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Module $module)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Module $module)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Module $module)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Module $module)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRepositoryInterface');
        return $cache->flush();
    }

}