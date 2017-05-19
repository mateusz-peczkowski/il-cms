<?php

namespace App\Observers;

use App\Page;

class PageObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Page $page)
    {
        $cache = resolve('App\Repositories\Contracts\PageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Page $page)
    {
        $cache = resolve('App\Repositories\Contracts\PageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Page $page)
    {
        $cache = resolve('App\Repositories\Contracts\PageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Page $page)
    {
        $cache = resolve('App\Repositories\Contracts\PageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Page $page)
    {
        $cache = resolve('App\Repositories\Contracts\PageRepositoryInterface');
        return $cache->flush();
    }

}