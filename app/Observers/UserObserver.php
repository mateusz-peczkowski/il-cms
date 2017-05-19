<?php

namespace App\Observers;

use App\User;

class UserObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(User $user)
    {
        $cache = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(User $user)
    {
        $cache = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(User $user)
    {
        $cache = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(User $user)
    {
        $cache = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(User $user)
    {
        $cache = resolve('App\Repositories\Contracts\UserRepositoryInterface');
        return $cache->flush();
    }

}