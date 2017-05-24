<?php

namespace App\Observers;

use App\Seo;

class SeoObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Seo $seo)
    {
        $cache = resolve('App\Repositories\Contracts\SeoRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Seo $seo)
    {
        $cache = resolve('App\Repositories\Contracts\SeoRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Seo $seo)
    {
        $cache = resolve('App\Repositories\Contracts\SeoRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Seo $seo)
    {
        $cache = resolve('App\Repositories\Contracts\SeoRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Seo $seo)
    {
        $cache = resolve('App\Repositories\Contracts\SeoRepositoryInterface');
        return $cache->flush();
    }

}