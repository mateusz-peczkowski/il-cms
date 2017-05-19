<?php

namespace App\Observers;

use App\Option;

class OptionObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Option $option)
    {
        $cache = resolve('App\Repositories\Contracts\OptionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Option $option)
    {
        $cache = resolve('App\Repositories\Contracts\OptionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Option $option)
    {
        $cache = resolve('App\Repositories\Contracts\OptionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Option $option)
    {
        $cache = resolve('App\Repositories\Contracts\OptionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Option $option)
    {
        $cache = resolve('App\Repositories\Contracts\OptionRepositoryInterface');
        return $cache->flush();
    }

}