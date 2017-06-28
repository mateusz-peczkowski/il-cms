<?php

namespace App\Observers;

use App\Section;

class SectionObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Section $section)
    {
        $cache = resolve('App\Repositories\Contracts\SectionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Section $section)
    {
        $cache = resolve('App\Repositories\Contracts\SectionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Section $section)
    {
        $cache = resolve('App\Repositories\Contracts\SectionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Section $section)
    {
        $cache = resolve('App\Repositories\Contracts\SectionRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Section $section)
    {
        $cache = resolve('App\Repositories\Contracts\SectionRepositoryInterface');
        return $cache->flush();
    }

}