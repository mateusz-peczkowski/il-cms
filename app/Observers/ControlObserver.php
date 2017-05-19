<?php

namespace App\Observers;

use App\Control;

class ControlObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Control $control)
    {
        $cache = resolve('App\Repositories\Contracts\ControlRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Control $control)
    {
        $cache = resolve('App\Repositories\Contracts\ControlRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Control $control)
    {
        $cache = resolve('App\Repositories\Contracts\ControlRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Control $control)
    {
        $cache = resolve('App\Repositories\Contracts\ControlRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Control $control)
    {
        $cache = resolve('App\Repositories\Contracts\ControlRepositoryInterface');
        return $cache->flush();
    }

}