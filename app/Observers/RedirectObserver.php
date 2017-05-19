<?php

namespace App\Observers;

use App\Redirect;

class RedirectObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Redirect $redirect)
    {
        $cache = resolve('App\Repositories\Contracts\RedirectRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Redirect $redirect)
    {
        $cache = resolve('App\Repositories\Contracts\RedirectRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Redirect $redirect)
    {
        $cache = resolve('App\Repositories\Contracts\RedirectRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Redirect $redirect)
    {
        $cache = resolve('App\Repositories\Contracts\RedirectRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Redirect $redirect)
    {
        $cache = resolve('App\Repositories\Contracts\RedirectRepositoryInterface');
        return $cache->flush();
    }

}