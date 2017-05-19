<?php

namespace App\Observers;

use App\Translation;

class TranslationObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Translation $translation)
    {
        $cache = resolve('App\Repositories\Contracts\TranslationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Translation $translation)
    {
        $cache = resolve('App\Repositories\Contracts\TranslationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Translation $translation)
    {
        $cache = resolve('App\Repositories\Contracts\TranslationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Translation $translation)
    {
        $cache = resolve('App\Repositories\Contracts\TranslationRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Translation $translation)
    {
        $cache = resolve('App\Repositories\Contracts\TranslationRepositoryInterface');
        return $cache->flush();
    }

}