<?php

namespace App\Observers;

use App\Navigation;

class NavigationObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Navigation $navigation)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Navigation $navigation)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Navigation $navigation)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Navigation $navigation)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Navigation $navigation)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationRepositoryInterface');
        return $cache->flush();
    }

}