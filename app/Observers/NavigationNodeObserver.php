<?php

namespace App\Observers;

use App\NavigationNode;

class NavigationNodeObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(NavigationNode $navigation_node)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationNodeRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(NavigationNode $navigation_node)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationNodeRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(NavigationNode $navigation_node)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationNodeRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(NavigationNode $navigation_node)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationNodeRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(NavigationNode $navigation_node)
    {
        $cache = resolve('App\Repositories\Contracts\NavigationNodeRepositoryInterface');
        return $cache->flush();
    }

}